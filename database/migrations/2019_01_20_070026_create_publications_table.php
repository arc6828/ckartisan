<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publications', function (Blueprint $table) {
          $table->increments('id');
          $table->text('authors')->nullable();
          $table->text('title')->nullable();
          $table->text('publisher')->nullable();
          $table->integer('date')->nullable();
          $table->integer('month')->nullable();
          $table->integer('year')->nullable();
          $table->string('pages')->nullable();
          $table->string('type')->nullable();
          $table->string('language')->nullable();
          $table->string('city')->nullable();     //Conference Only
          $table->text('place')->nullable();      //Conference Only
          $table->timestamps();
        });
        //•	ฐาปกรณ์ ต้นสมบูรณ์ และ วิศรุต ขวัญคุ้ม. “ระบบจอง-ยืมรูปเล่มโปรเจคสาขาวิทยาการคอมพิวเตอร”.
          //การประชุมวิชาการระดับชาติด้านวิทยาศาสตร์และเทคโนโลยี ครั้งที่ 2 (NCOST2), 2561, หน้า 54-61.
        //•	วิศรุต ขวัญคุ้ม, จิรารัตน์ เอี่ยมสอาด และธนภัทร เอี่ยมตาล. “การประยุกต์ใช้ขั้นตอนวิธีหิ่งห้อยสำหรับค้นหาแผนการทดลองแบบลาตินไฮเปอร์คิวในการจำลองการทดลองด้วยคอมพิวเตอร์”. การประชุมวิชาการระดับชาติและนานาชาติ ครั้งที่ 2 (NIRC2018), 2561, หน้า 265-274.
        //•	ธนัชพร หันทะยุง และ วิศรุต ขวัญคุ้ม. “การพัฒนาแอพพลิเคชั่นสำหรับการจัดการร้านไก่ย่างห้าดาวบนระบบปฏิบัติการแอนดรอยด์ กรณีศึกษา ร้านไก่ย่างห้าดาว สาขาเคหะออเงิน”. การประชุมวิชาการระดับชาติ วิทยาศาสตร์และเทคโนโลยีระหว่างสถาบัน ครั้งที่ 6 (ASTC2018), 2561, หน้า IT270-IT276.
        //•	วิศรุต ขวัญคุ้ม, จิรารัตน์ เอี่ยมสอาด, ธนภัทร เอี่ยมตาล. “การประยุกต์ใช้วิธีสับค่าและวิธีปรับแก้ในขั้นตอนวิธีสืบค้นสำหรับการจำลองการทดลองด้วยคอมพิวเตอร์”. วารสารวิทยาศาสตร์และเทคโนโลยี มหาวิทยาลัยมหาสารคาม ปีที่ 37ฉบับที่ 4 (กรกฎาคม - สิงหาคม 2561).
        //•	จิรารัตน์ เอี่ยมสอาด, ธนภัทร เอี่ยมตาล และวิศรุต ขวัญคุ้ม. “อัลกอริทึมตรวจจับโพรงของพื้นกระเบื้องโดยใช้สัญญาณเสียง”. การประชุมวิชาการระดับชาติ ครั้งที่ 3 มหาวิทยาลัยราชภัฏกาญจนบุรี, 2561, หน้า 134-139.
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publications');
    }
}
