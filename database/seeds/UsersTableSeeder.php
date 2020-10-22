<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $UsersData = array(
            array('id' => 1, 'fname' => 'Admin', 'mname' => 'NA', 'lname' => 'NA', 'address' => 'Pardo Cebu', 'contact_num' => '0912312321', 'email' => 'act.dcatindoy@gmail.com', 'email_verified_at' => "2020-06-08 07:57:47", 'password' => '$2y$10$EN8DMgNgmRlqVPmSOAvmJO9vM/VJHWvgsXkBg9A2wgLnwidiOpWDO', 'user_role' => 99, 'is_active' => 1, 'is_pending' => 0, 'img' => "NA", 'remember_token' => "NA", 'created_at' => '2020-06-07 02:42:21', 'updated_at' => '2020-06-08 07:57:47'),
            array('id' => 2, 'fname' => 'Super', 'mname' => 'Name', 'lname' => 'Admin', 'address' => 'NA', 'contact_num' => '09123213123', 'email' => 'admin@creamline.com', 'email_verified_at' => "2020-06-08 07:57:47", 'password' => '$2y$10$FbbuyBRiQLrHbtXfJYl1j.uMj5cGl1yuT7kuhsamt9q7hXRHkDi8G', 'user_role' => 99, 'is_active' => 1, 'is_pending' => 0, 'img' => "NA", 'remember_token' => "NA", 'created_at' => '2020-06-07 02:45:27', 'updated_at' => '2020-06-07 02:45:27'),
        );
        DB::table('users')->insert($UsersData);

        $data = array(
            array('id' => 1, 'area_name' => 'Cebu City', 'area_code' => '6000', 'is_deleted' => 0, 'created_at' => '2020-06-06 20:44:12', 'updated_at' => '2020-06-06 20:45:36'),
            array('id' => 2, 'area_name' => 'Alcantara City', 'area_code' => '6033', 'is_deleted' => 0, 'created_at' => '2020-06-06 20:44:12', 'updated_at' => '2020-06-06 20:45:36'),
            array('id' => 3, 'area_name' => 'Boljoon', 'area_code' => '6024', 'is_deleted' => 0, 'created_at' => '2020-06-06 20:44:12', 'updated_at' => '2020-06-06 20:45:36'),
            array('id' => 4, 'area_name' => 'Danao City', 'area_code' => '6004', 'is_deleted' => 0, 'created_at' => '2020-06-06 20:44:12', 'updated_at' => '2020-06-06 20:45:36'),
            array('id' => 5, 'area_name' => 'Moalboal', 'area_code' => '6032', 'is_deleted' => 0, 'created_at' => '2020-06-06 20:44:12', 'updated_at' => '2020-06-06 20:45:36'),
            array('id' => 6, 'area_name' => 'Santander', 'area_code' => '6026', 'is_deleted' => 0, 'created_at' => '2020-06-06 20:44:12', 'updated_at' => '2020-06-06 20:45:36'),
            array('id' => 7, 'area_name' => 'Naga City', 'area_code' => '6037', 'is_deleted' => 0, 'created_at' => '2020-06-06 20:44:12', 'updated_at' => '2020-06-06 20:45:36'),
            array('id' => 8, 'area_name' => 'Dumanjug', 'area_code' => '6035', 'is_deleted' => 0, 'created_at' => '2020-06-06 20:44:12', 'updated_at' => '2020-06-06 20:45:36'),
            array('id' => 9, 'area_name' => 'Carcar', 'area_code' => '6019', 'is_deleted' => 0, 'created_at' => '2020-06-06 20:44:12', 'updated_at' => '2020-06-06 20:45:36'),
            array('id' => 10, 'area_name' => 'Mandaue', 'area_code' => '6014', 'is_deleted' => 0, 'created_at' => '2020-06-06 20:44:12', 'updated_at' => '2020-06-06 20:45:36'),
            array('id' => 11, 'area_name' => 'Compostela', 'area_code' => '6003', 'is_deleted' => 0, 'created_at' => '2020-06-06 20:44:12', 'updated_at' => '2020-06-06 20:45:36'),
            array('id' => 12, 'area_name' => 'Talisay City', 'area_code' => '6045', 'is_deleted' => 0, 'created_at' => '2020-06-06 20:44:12', 'updated_at' => '2020-06-06 20:45:36')
        );
        DB::table('areas')->insert($data);
    }
}
