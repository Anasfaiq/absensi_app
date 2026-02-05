<?php
  include 'config/conn.php';

  // recap total siswa
  $total_siswa_q = mysqli_query($conn, "SELECT COUNT(*) AS total FROM siswa");
  $total_siswa = mysqli_fetch_assoc($total_siswa_q)['total'];

  // recap hadir hari ini
  $hadir_q = mysqli_query($conn, "SELECT COUNT(*) AS total FROM absensi WHERE status = 'hadir' AND tanggal = CURDATE()");
  $hadir = mysqli_fetch_assoc($hadir_q)['total'];

  // recap tidak hadir (izin + sakit + alpha) hari ini
  $tidak_hadir_q = mysqli_query($conn, "SELECT COUNT(*) AS total FROM absensi WHERE status != 'hadir' AND tanggal = CURDATE()");
  $tidak_hadir = mysqli_fetch_assoc($tidak_hadir_q)['total'];

  // recap mingguan (7 hari terakhir)
  $weekly_q = mysqli_query($conn, "SELECT status, COUNT(*) AS total FROM absensi WHERE tanggal >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) GROUP BY status");

  // recap bulanan (bulan ini)
  $monthly_q = mysqli_query($conn, "SELECT status, COUNT(*) AS total FROM absensi WHERE MONTH(tanggal) = MONTH(CURDATE()) 
                                                  AND YEAR(tanggal) = YEAR(CURDATE()) GROUP BY status");

  // helper biar ga undefined
  function mapStatus($query) {
    $data = ['hadir'=>0, 'izin'=>0, 'sakit'=>0, 'alpha'=>0];
    while ($row = mysqli_fetch_assoc($query)) {
      $data[$row['status']] = $row['total'];
    }
    return $data;
  }

$weekly  = mapStatus($weekly_q);
$monthly = mapStatus($monthly_q);



  $absensi_q = mysqli_query($conn, "SELECT absensi.*, siswa.nis, siswa.nama_siswa, kelas.nama_kelas FROM absensi
                                                  JOIN siswa ON absensi.id_siswa = siswa.id_siswa
                                                  JOIN kelas ON siswa.id_kelas = kelas.id_kelas
                                                  ORDER BY absensi.tanggal DESC");

  $dropdown_q = mysqli_query($conn, "SELECT siswa.id_siswa, siswa.nama_siswa, kelas.nama_kelas FROM siswa
                                                    JOIN kelas ON siswa.id_kelas = kelas.id_kelas
                                                    ORDER BY kelas.nama_kelas, siswa.nama_siswa");

  if (isset($_POST['action'])) {

    $id_siswa  = $_POST['id_siswa']  ?? null;
    $tanggal   = $_POST['tanggal']   ?? null;
    $status    = $_POST['status']    ?? null;
    $id_absen  = $_POST['id_absensi'] ?? null;

    // ADD (pakai logic lama lu)
    if ($_POST['action'] === 'add') {

      $cek_q = mysqli_query(
        $conn,
        "SELECT id_absensi FROM absensi
        WHERE id_siswa = '$id_siswa'
        AND tanggal = '$tanggal'
        LIMIT 1"
      );

      if (mysqli_num_rows($cek_q) > 0) {
        $data = mysqli_fetch_assoc($cek_q);
        $id_absensi = $data['id_absensi'];

        mysqli_query(
          $conn,
          "UPDATE absensi
          SET status = '$status'
          WHERE id_absensi = '$id_absensi'"
        );

      } else {
        mysqli_query(
          $conn,
          "INSERT INTO absensi (id_siswa, tanggal, status)
          VALUES ('$id_siswa', '$tanggal', '$status')"
        );
      }
    }

    // EDIT (manual edit dari tabel)
    if ($_POST['action'] === 'edit') {
      mysqli_query(
        $conn,
        "UPDATE absensi
        SET id_siswa='$id_siswa',
            tanggal='$tanggal',
            status='$status'
        WHERE id_absensi='$id_absen'"
      );
    }

    // DELETE
    if ($_POST['action'] === 'delete') {
      mysqli_query(
        $conn,
        "DELETE FROM absensi
        WHERE id_absensi='$id_absen'"
      );
    }
  }


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Absensi Siswa</title>
  <link rel="stylesheet" href="src/output.css">
</head>
<body class="min-h-screen relative">
  <nav class="flex justify-between shadow-md border-b border-gray-100 px-64 py-4">
    <section class="flex items-center gap-2">
      <div class="rounded-xl w-10 h-10 bg-blue-500 text-white flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg"
        width="24"
        height="24" 
        viewBox="0 0 24 24" 
        fill="none" 
        stroke="currentColor" 
        stroke-width="2" 
        stroke-linecap="round" 
        stroke-linejoin="round">
        <path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0"/>
        <path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0"/><path d="M3 6l0 13"/><path d="M12 6l0 13"/>
        <path d="M21 6l0 13"/></svg>
      </div>
      <span class="font-semibold text-lg">Absensi Siswa</span>
    </section>
    <section class="flex items-center gap-2">
      <span class="font-semibold">Guru</span>
      <div class="rounded-full w-10 h-10 bg-blue-100 text-blue-500 flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" 
        width="24" 
        height="24" 
        viewBox="0 0 24 24" 
        fill="none" 
        stroke="currentColor" 
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
        >
          <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"/>
          <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
        </svg>
      </div>
    </section>
  </nav>

  <main class="px-64 my-8">
    <section>
      <div class="tracking-wide flex flex-col gap-1">
        <h3 class="text-3xl font-semibold">Attendance Dashboard</h3>
        <p class="text-md">Track and Manage student attendance records</p>
      </div>
      <div class="grid grid-cols-3 gap-4 justify-between items-center mt-8">
        <div class="shadow-md border border-gray-100 rounded-xl flex items-center justify-between p-4
                    hover:scale-102 hover:shadow-lg transition-all">
          <div>
            <p class="text-md">Total Students</p>
            <h3 class="text-3xl font-semibold"><?= $total_siswa ?></h3>
          </div>
          <div class="text-blue-500 bg-blue-100 p-3 rounded-xl">
            <svg 
              xmlns="http://www.w3.org/2000/svg" 
              width="24" 
              height="24" 
              viewBox="0 0 24 24" 
              fill="none" 
              stroke="currentColor" 
              stroke-width="2" 
              stroke-linecap="round" 
              stroke-linejoin="round"
              >
                <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"/>
              <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
              <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"/>
            </svg>
          </div>
        </div>

        <div class="shadow-md border border-gray-100 rounded-xl flex items-center justify-between p-4
                    hover:scale-102 hover:shadow-lg transition-all">
          <div>
            <p class="text-md">Present Today</p>
            <h3 class="text-3xl font-semibold"><?= $hadir ?></h3>
          </div>
          <div class="text-green-500 bg-green-100 p-3 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" 
              width="24" 
              height="24" 
              viewBox="0 0 24 24" 
              fill="none" 
              stroke="currentColor" 
              stroke-width="2" 
              stroke-linecap="round" 
              stroke-linejoin="round"
              >
                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"/>
              <path d="M6 21v-2a4 4 0 0 1 4 -4h4"/>
              <path d="M15 19l2 2l4 -4"/>
            </svg>
          </div>
        </div>

        <div class="shadow-md border border-gray-100 rounded-xl flex items-center justify-between p-4
                    hover:scale-102 hover:shadow-lg transition-all">
          <div>
            <p class="text-md">Absent Today</p>
            <h3 class="text-3xl font-semibold"><?= $tidak_hadir ?></h3>
          </div>
          <div class="text-red-500 bg-red-100 p-3 rounded-xl">
           <svg xmlns="http://www.w3.org/2000/svg" 
              width="24" 
              height="24" 
              viewBox="0 0 24 24" 
              fill="none" 
              stroke="currentColor" 
              stroke-width="2" 
              stroke-linecap="round" 
              stroke-linejoin="round"
              >
              <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"/>
              <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5"/>
              <path d="M22 22l-5 -5"/>
              <path d="M17 22l5 -5"/>
            </svg>
          </div>
        </div>
      </div>
    </section>

    <section>
      <div class="flex justify-between items-center mt-8">
        <p class="font-semibold text-2xl">Attendance Records</p>
        <button id="openModalBtn" class="bg-blue-600 text-white flex items-center gap-2 px-6 py-3 rounded-xl font-semibold
                        hover:bg-white hover:text-blue-600 border hover:border-blue-600 hover:scale-105 active:scale-95 transition-all">
          <svg xmlns="http://www.w3.org/2000/svg" 
            width="24"
            height="24"
            viewBox="0 0 24 24" 
            fill="none"
            stroke="currentColor"
            stroke-width="2" 
            stroke-linecap="round" 
            stroke-linejoin="round"
            >
            <path d="M12 5l0 14"/>
            <path d="M5 12l14 0"/>
          </svg>
          Mark Attendance
        </button>
      </div>
      <table class="w-full rounded-xl border border-gray-200 shadow-lg overflow-hidden mt-8">
        <thead class="border-b border-gray-300">
          <tr>
            <td class="p-3 font-semibold">No</td>
            <td class="p-3 font-semibold">Student Name</td>
            <td class="p-3 font-semibold">Class</td>
            <td class="p-3 font-semibold">Date</td>
            <td class="p-3 font-semibold">Status</td>
            <td class="p-3 font-semibold">Action</td>
          </tr>
        </thead>
        <tbody>
          <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($absensi_q)) :
          ?>
          <tr class="border-b border-gray-200 hover:bg-gray-100 transition-all">
            <td class="p-3"><?= $no++ ?></td>
            <td class="p-3"><?= $row['nama_siswa'] ?></td>
            <td class="p-3"><?= $row['nama_kelas'] ?></td>
            <td class="p-3"><?= $row['tanggal'] ?></td>
            <td class="p-3"><?= $row['status'] ?></td>
            <td class="p-3">
              <button 
                class="editBtn rounded-xl p-1 text-blue-600 hover:bg-blue-100/50 scale-95 hover:scale-100 active:scale-90 transition-all"
                data-id="<?= $row['id_absensi'] ?>"
                data-siswa="<?= $row['id_siswa'] ?>"
                data-tanggal="<?= $row['tanggal'] ?>"
                data-status="<?= $row['status'] ?>"
              >
                <svg xmlns="http://www.w3.org/2000/svg" 
                  width="24" 
                  height="24" 
                  viewBox="0 0 24 24" 
                  fill="none" 
                  stroke="currentColor" 
                  stroke-width="2" 
                  stroke-linecap="round" 
                  stroke-linejoin="round"
                  >
                  <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4"/>
                  <path d="M13.5 6.5l4 4"/>
                </svg>
              </button>
              <form method="POST" class="inline">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id_absensi" value="<?= $row['id_absensi'] ?>">
                <button class="rounded-xl p-1 text-red-600 hover:bg-red-100/50 scale-95 hover:scale-100 active:scale-90 transition-all">
                  <svg xmlns="http://www.w3.org/2000/svg" 
                    width="24"
                    height="24" 
                    viewBox="0 0 24 24" 
                    fill="none" 
                    stroke="currentColor" 
                    stroke-width="2" 
                    stroke-linecap="round" 
                    stroke-linejoin="round">
                      <path d="M4 7l16 0"/>
                    <path d="M10 11l0 6"/>
                    <path d="M14 11l0 6"/>
                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                  </svg>
                </button>
              </form>
            </td>
          </tr>
          <?php
            endwhile;
          ?>
        </tbody>
      </table>
    </section>

    <section class="mt-12">
      <p class="font-semibold text-2xl mb-6">Attendance Recap</p>

      <div class="grid grid-cols-2 gap-6">

        <!-- WEEKLY -->
        <div class="shadow-md border border-gray-100 rounded-xl p-6 hover:scale-102 hover:shadow-lg transition-all">
          <p class="font-semibold text-xl mb-4">Weekly Recap (Last 7 Days)</p>

          <div class="grid grid-cols-4 gap-4 text-center">
            <div class="bg-green-100 text-green-600 rounded-xl p-4">
              <p class="text-sm">Hadir</p>
              <p class="text-2xl font-semibold"><?= $weekly['hadir'] ?></p>
            </div>
            <div class="bg-blue-100 text-blue-600 rounded-xl p-4">
              <p class="text-sm">Izin</p>
              <p class="text-2xl font-semibold"><?= $weekly['izin'] ?></p>
            </div>
            <div class="bg-yellow-100 text-yellow-600 rounded-xl p-4">
              <p class="text-sm">Sakit</p>
              <p class="text-2xl font-semibold"><?= $weekly['sakit'] ?></p>
            </div>
            <div class="bg-red-100 text-red-600 rounded-xl p-4">
              <p class="text-sm">Alpha</p>
              <p class="text-2xl font-semibold"><?= $weekly['alpha'] ?></p>
            </div>
          </div>
        </div>

        <!-- MONTHLY -->
        <div class="shadow-md border border-gray-100 rounded-xl p-6 hover:scale-102 hover:shadow-lg transition-all">
          <p class="font-semibold text-xl mb-4">Monthly Recap (This Month)</p>

          <div class="grid grid-cols-4 gap-4 text-center">
            <div class="bg-green-100 text-green-600 rounded-xl p-4">
              <p class="text-sm">Hadir</p>
              <p class="text-2xl font-semibold"><?= $monthly['hadir'] ?></p>
            </div>
            <div class="bg-blue-100 text-blue-600 rounded-xl p-4">
              <p class="text-sm">Izin</p>
              <p class="text-2xl font-semibold"><?= $monthly['izin'] ?></p>
            </div>
            <div class="bg-yellow-100 text-yellow-600 rounded-xl p-4">
              <p class="text-sm">Sakit</p>
              <p class="text-2xl font-semibold"><?= $monthly['sakit'] ?></p>
            </div>
            <div class="bg-red-100 text-red-600 rounded-xl p-4">
              <p class="text-sm">Alpha</p>
              <p class="text-2xl font-semibold"><?= $monthly['alpha'] ?></p>
            </div>
          </div>
        </div>

      </div>
    </section>

  </main>

  <!-- backdrop -->
  <div id="modalBackdrop" class="fixed inset-0 bg-black/50 hidden z-40 transition-opacity duration-300"></div>

  <!-- modal -->
  <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] hidden bg-white rounded-xl z-50 
              transform scale-95 opacity-0 transition-all duration-300 ease-out" id="modal">
    <section class="flex items-center justify-between px-6 py-7 border-b border-gray-300">
      <p class="font-semibold text-xl">Mark Attendance</p>
      <button class="closeModalBtn text-gray-500 hover:bg-gray-100 p-2 rounded-xl">
        <svg xmlns="http://www.w3.org/2000/svg" 
          width="24" 
          height="24" 
          viewBox="0 0 24 24" 
          fill="none" 
          stroke="currentColor" 
          stroke-width="2" 
          stroke-linecap="round" 
          stroke-linejoin="round"
          >
            <path d="M18 6l-12 12"/>
          <path d="M6 6l12 12"/>
        </svg>
      </button>
    </section>
    <section>
      <form method="POST" class="p-6 flex flex-col gap-3">
        <input type="hidden" name="action" id="formAction" value="add">
        <input type="hidden" name="id_absensi" id="idAbsensi">

        <div class="flex flex-col gap-1">
          <label class="font-semibold text-gray-600">Student Name</label>
          <select name="id_siswa" id="" class="px-4 py-3 border border-gray-300 rounded-xl" required>
            <option value="" disabled selected hidden>Select a student</option>
            <?php
              while ($row = mysqli_fetch_assoc($dropdown_q)) :
            ?>
            <option value="<?= $row['id_siswa'] ?>"><?= $row['nama_siswa'] ?> - <?= $row['nama_kelas'] ?></option>
            <?php
              endwhile;
            ?>
          </select>
        </div>
        <div class="flex flex-col gap-1">
          <label class="font-semibold text-gray-600">Date</label>
          <input type="date" name="tanggal" class="px-4 py-3 border border-gray-300 rounded-xl" required>
        </div>
        <div class="radio-group flex flex-col gap-2">
          <label class="font-semibold text-gray-600">Attendance Status</label>
          <label class="px-4 py-3 border border-gray-300 rounded-xl">
            <input type="radio" name="status" value="hadir">
            <span>Hadir</span>
          </label>
          <label class="px-4 py-3 border border-gray-300 rounded-xl">
            <input type="radio" name="status" value="izin">
            <span>Izin</span>
          </label>
          <label class="px-4 py-3 border border-gray-300 rounded-xl">
            <input type="radio" name="status" value="sakit">
            <span>Sakit</span>
          </label>
          <label class="px-4 py-3 border border-gray-300 rounded-xl">
            <input type="radio" name="status" value="alpha">
            <span>Alpha</span>
          </label>
          <input type="hidden" name="action" value="add">
        </div>
        <div class="grid grid-cols-2 gap-2 text-center items-center justify-center mt-4">
          <button class="closeModalBtn bg-gray-200 text-black flex items-center justify-center gap-2 px-6 py-3 rounded-xl font-semibold text-center
                        hover:bg-white hover:text-red-600 border border-gray-200 hover:border-red-600 hover:scale-105 active:scale-95 transition-all">
            Cancel
          </button>
          <button type="submit" class="bg-blue-600 text-white flex items-center justify-center gap-2 px-6 py-3 rounded-xl font-semibold text-center
                        hover:bg-white hover:text-blue-600 border hover:border-blue-600 hover:scale-105 active:scale-95 transition-all">
            Save Attendance
          </button>
        </div>
      </form>
    </section>
  </div>

  <script src="src/script.js"></script>
</body>
</html>