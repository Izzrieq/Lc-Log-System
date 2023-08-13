<?php
include_once "COMPONENT/DB/config.php";
include "COMPONENT/header.php";

$result = mysqli_query($conn, "SELECT * FROM lcdetails ORDER BY id DESC");
 
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TLCP DATA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

 </head>
 <body>
    
 <center class="font-bold text-2xl mt-6">LIST TLCP</center>
        <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-8 border border-green-700 rounded ml-20">
            <a href='tlcp-add.php'>ADD TLCP</a>
        </button>     
 <div class="overflow-hidden">
     <div class="flex flex-col pt-6 pr-4 pl-4">
     <div class="overflow-x-auto sm:-mx-8 lg:-mx-8">
         <div class="py-2 inline-block min-w-full sm:px-8 lg:px-8">
             <table class="min-w-full border text-center bg-white">
             <thead>
                 <tr class="border-b bg-gray-700">
                 <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">
                     ID
                 </th>
                 <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">
                     STATE_ID
                 </th>
                 <th scope="col" class="text-md font-medium text-white px-4 py-2 border-r">
                     BIZ_TYPE
                 </th>
                 <th scope="col" class="text-md font-medium text-white px-8 py-2 border-r">
                     LITTLECALIPH_ID 
                 </th>
                 <th scope="col" class="text-md font-medium text-white px-4 py-2 border-r">
                     OPERATOR_NAME
                 </th>
                 <th scope="col" class="text-md font-medium text-white px-4 py-2 border-r">
                     OWNER_NAME
                 </th>
                 <th scope="col" class="text-md font-medium text-white px-4 py-2 border-r">
                     EDU_EMAIL
                 </th>
                 <th scope="col" class="text-md font-medium text-white px-4 py-2 border-r">
                     KINDERGARTEN NUMBER
                 </th>
                 <th scope="col" class="text-md font-medium text-white px-4 py-2 border-r">
                     ACTION
                 </th>
                 </tr>
                <?php
                $result = mysqli_query($conn,"SELECT * FROM lcdetails"); 
                while ($r = mysqli_fetch_array($result)){
                ?>  
                <tr>
                    <td class="border-r border-b"><?php echo $r['id']; ?></td>
                    <td class="border-r border-b"><?php echo $r['stateid']; ?></td>
                    <td class="border-r border-b"><?php echo $r['bizstype']; ?></td>
                    <td class="border-r border-b px-2"><?php echo $r['lcid']; ?></td>
                    <td class="border-r border-b px-8"><?php echo $r['operatorname']; ?></td>
                    <td class="border-r border-b px-8"><?php echo $r['ownername']; ?></td>
                    <td class="border-r border-b px-2"><?php echo $r['eduemail']; ?></td>
                    <td class="border-r border-b px-0"><?php echo $r['kindernohp']; ?></td>
                    <td class="border-r border-b p-2">
                        <div class="flex items-center justify-between mt-2">
                            <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 border border-gray-700 rounded">
                                <a href='tlcp-info.php?id=<?php echo $r['id'];?>'>INFO</a>
                            </button>
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 border border-gray-700 rounded">
                                <a href='tlcp-update.php?id=<?php echo $r['id'];?>'>UPDATE</a>
                            </button>
                            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 border border-red-700 rounded">
                                <a href='delete.php?id=<?php echo $r['id'];?>'>DELETE</a>
                            </button>
                        </div>
                    </td>
                    
                </tr>
                <?php 
                }
                ?>
             </thead>
             </table>   
         </div>
     </div>
     </div>
    </div>
        
</body>
 </html>