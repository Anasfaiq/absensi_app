<?php
  include 'config/conn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Absensi Siswa</title>
  <link rel="stylesheet" href="src/output.css">
</head>
<body class="min-h-screen">
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

  <main class="px-64 mt-8">
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
            <h3 class="text-3xl font-semibold">10</h3>
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
            <p class="text-md">Total Students</p>
            <h3 class="text-3xl font-semibold">10</h3>
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
            <p class="text-md">Total Students</p>
            <h3 class="text-3xl font-semibold">10</h3>
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
        <button class="bg-blue-600 text-white flex items-center gap-2 px-6 py-3 rounded-xl font-semibold
                        hover:bg-white hover:text-blue-600 border hover:border-blue-600 hover:scale-102 active:scale-100 transition-all">
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
      <table>
        <thead>
          <tr>
            <td>Student Name</td>
            <td>Class</td>
            <td>Date</td>
            <td>Status</td>
            <td>Action</td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Emma Johnson</td>
            <td>Grade 3-A</td>
            <td>Feb 3, 2026</td>
            <td>Present</td>
            <td>
              <button class="rounded-xl p-1 text-blue-600 hover:bg-blue-100/50 transition-all">
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
              <button class="rounded-xl p-1 text-red-600 hover:bg-red-100/50 transition-all">
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
            </td>
          </tr>
        </tbody>
      </table>
    </section>
  </main>
</body>
</html>