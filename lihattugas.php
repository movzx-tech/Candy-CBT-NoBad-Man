<?php
$ac = dekripsi($ac);
echo $ac;
$tugas = mysqli_fetch_array(mysqli_query($koneksi, "select * from tugas where id_tugas='$ac'"));
$guru = fetch($koneksi, 'pengawas', ['id_pengawas' => $tugas['id_guru']]);
$telegram = fetch($koneksi, 'telegram_bot', ['tlIdGuru' => $tugas['id_guru']]);
$cekSend = $dbb->CekAktifSend();
?>
<div class='row'>
  <div class='col-md-12'>
    <div class='box box-solid'>
      <div class='box-header with-border'>

        <h3 class='box-title'><i class="fas fa-file-signature"></i> Detail Tugas Siswa</h3>
      </div><!-- /.box-header -->
      <div class='box-body' id="loaddiv">
        <table class='table table-bordered table-striped'>
          <tr>
            <th width='150'>Mata Pelajaran</th>
            <td width='10'>:</td>
            <td><?= $tugas['mapel'] ?></td>

          </tr>
          <tr>
            <th>Guru Pengampu</th>
            <td width='10'>:</td>
            <td><?= $guru['nama'] ?></td>

          </tr>
          <tr>
            <th>Tgl Mulai</th>
            <td width='10'>:</td>
            <td><?= $tugas['tgl_mulai'] ?></td>
          </tr>
          <tr>
            <th>Tgl Selesai</th>
            <td width='10'>:</td>
            <td><?= $tugas['tgl_selesai'] ?></td>
          </tr>

        </table>
        <br>
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Materi & Soal</a></li>
            <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Kirim Jawaban</a></li>

          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
              <?php if ($tugas['file'] ==null or $tugas['file'] =="") { }else{ ?>
                Download Materi Pendukung<p>
                  <a download target="_blank" href='<?= $homeurl ?>/<?= $linkguru ?>/tugas/<?= $tugas['id_guru'] ?>/<?= $tugas['file'] ?>' class="btn btn-primary"><?= $tugas['file'] ?></a>
                <?php } ?>
                <center>
                  <h3><?= $tugas['judul'] ?></h3>
                </center>
                <p class="text-justify"><?= $tugas['tugas'] ?></p>
              </div>
              <div class="tab-pane" id="tab_2">
                <?php
                $kondisi = array(
                  'id_siswa' => $_SESSION['id_siswa'],
                  'id_tugas' => $tugas['id_tugas']
                );
                $jawab_tugas = fetch($koneksi, 'jawaban_tugas', $kondisi);
                if ($jawab_tugas) {
                  $jawaban = $jawab_tugas['jawaban'];
                } else {
                  $jawaban = "";
                }
                ?>
                <?php if ($jawab_tugas['nilai'] <> '') { ?>
                  <div class="alert alert-success" role="alert">
                    <strong>Jawaban telah dikoreksi dan dinilai</strong>
                  </div>
                  <h1>Nilai Kamu : <?= $jawab_tugas['nilai'] ?></h1>
                <?php } else { ?>
                  <div class="alert alert-danger" role="alert">
                    <strong>Kerjakan dengan jujur dan benar, jawaban akan digunakan sebagai absen.</strong>
                  </div>

                  <form id='formjawaban'>
                    <input type="hidden" name="id_tugas" value="<?= $tugas['id_tugas'] ?>">
                    <input type="hidden" name="id_guru" value="<?= $tugas['id_guru'] ?>">
                    <input type="hidden" name="mapel2" value="<?= $tugas['mapel'] ?>">
                    <input type="hidden" name="id_telegram" value="<?= $telegram['tlChatId'] ?>">
                    <div class="form-group">
                      <label for="">Lembar Jawaban</label>
                     <!--  <textarea class="form-control" name="jawaban" id="txtjawaban" rows="10"><?= $jawaban ?></textarea> -->
                      <textarea id="summernote" name='jawaban'><?= $jawaban ?></textarea>
                    </div>
                    <?php if ($jawab_tugas['file'] == '') { ?>
                      <div class="form-group">
                        <label for="">Upload Jawaban</label>
                        <input type="file" class="form-control-file" name="file" aria-describedby="fileHelpId">
                        <small id="fileHelpId" class="form-text text-muted">jika jawaban diupload</small>
                      </div>
                    <?php } else { ?>

                      <div class="alert alert-success" role="alert">
                        <strong>file jawaban berhasil dikirim</strong>
                        <a href='<?= $homeurl ?>/guru/tugas_siswa/<?= $tugas['id_guru'] ?>/<?= $tugas['id_tugas'] ?>/<?= $jawab_tugas['file'] ?>' target="_blank">Lihat file</a>
                      </div>

                    <?php  } ?>

                    <div class="form-group">
                      <button type="submit" class="btn btn-primary">Simpan Jawaban</button>
                    </div>
                  </form>
                <?php  } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript">
$(document).ready(function() {
  //Agar Video Summoner editor responsif
        jQuery('.note-video-clip').each(function(){
            var tmp = jQuery(this).wrap('<p/>').parent().html();
            jQuery(this).parent().html('<div class="embed-responsive embed-responsive-16by9">'+tmp+'</div>');
          });
     $('#summernote').summernote({
        codeviewFilter: false,
        codeviewIframeFilter: true,
        focus,
      });

    $('#formjawaban').submit(function(e) {
      e.preventDefault();
      var data = new FormData(this);
      var homeurl = '<?= $homeurl ?>';

      $.ajax({
        type: 'POST',
        url: homeurl + '/simpantugas.php',
        enctype: 'multipart/form-data',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
        $("#pesanku").text("Sedang Di Proses !!!");
        $('.loader').show();
        },
        success: function(data) {
          console.log(data);
          if (data == 'ok') {
            toastr.success("jawaban berhasil dikirim");
            $("#loaddiv").load(window.location + " #loaddiv");
           
            <?php 
            if($token_bot['botActive']==1){
              if($cekSend['botSendTugas']==1){
                 $pesan='---Tugas Sudah Di Kirim---';
                 $date = date("d-m-Y");
                 $jam = date("H:i:s");
                ?>
                var settings = {
                  "async": true,
                  "crossDomain": true,
                  "url": "https://api.telegram.org/bot<?php echo $_SESSION['token_bot_telegram']; ?>/sendMessage",
                  "method": "POST",
                  "headers": {
                    "Content-Type": "application/json",
                    "cache-control": "no-cache"
                  },
                  "data": JSON.stringify({
                    "chat_id": "<?= $telegram['tlChatId'] ?>",
                    "text": "<b><?=$pesan?></b>\n <b><?=$_SESSION['nama_sekolah']?></b>\nMapel : <b><?= $tugas['mapel'] ?></b>\nNama : <b><?= $_SESSION['full_nama'] ?></b>\nKelas : <b><?= $_SESSION['id_kelas'] ?></b>\nTgl : <b><?= $date ?></b>\nJam : <b><?= $jam ?></b>",
                    "parse_mode":"HTML",
                  })
                }
            
                // $.ajax(settings).done(function (response) {
                //   console.log(response);
                // });
                $.ajax(settings).done();
             <?php  } } ?>
            location.reload(true);


          } 
          else if (data == 'update') {
            toastr.success("Update jawaban berhasil dikirim");
            $("#loaddiv").load(window.location + " #loaddiv");
           
            <?php 
            if($token_bot['botActive']==1){
              if($cekSend['botSendTugas']==1){
                 $pesan='---Update Tugas---';
                 $date = date("d-m-Y");
                 $jam = date("H:i:s");
                ?>
                var settings = {
                  "async": true,
                  "crossDomain": true,
                  "url": "https://api.telegram.org/bot<?php echo $_SESSION['token_bot_telegram']; ?>/sendMessage",
                  "method": "POST",
                  "headers": {
                    "Content-Type": "application/json",
                    "cache-control": "no-cache"
                  },
                  "data": JSON.stringify({
                    "chat_id": "<?= $telegram['tlChatId'] ?>",
                    "text": "<b><?=$pesan?></b>\n <b><?=$_SESSION['nama_sekolah']?></b>\nMapel : <b><?= $tugas['mapel'] ?></b>\nNama : <b><?= $_SESSION['full_nama'] ?></b>\nKelas : <b><?= $_SESSION['id_kelas'] ?></b>\nTgl : <b><?= $date ?></b>\nJam : <b><?= $jam ?></b>",
                    "parse_mode":"HTML",
                  })
                }
            
                // $.ajax(settings).done(function (response) {
                //   console.log(response);
                // });
                $.ajax(settings).done();
             <?php  } } ?>
            location.reload(true);
          }
          else {
            toastr.error("jawaban gagal dikirim");
          }
        }
      });
      return false;
    });
});
  </script>
<script type="text/javascript">
$(document).ready(function() {
    tinymce.init({
      selector: '#txtjawaban',
      plugins: [
      'advlist autolink lists link image charmap print preview hr anchor pagebreak',
      'searchreplace wordcount visualblocks visualchars code fullscreen',
      'insertdatetime media nonbreaking save table contextmenu directionality',
      'emoticons template paste textcolor colorpicker textpattern imagetools uploadimage paste'
      ],

      toolbar: 'bold italic fontselect fontsizeselect | alignleft aligncenter alignright bullist numlist  backcolor forecolor | emoticons code | imagetools link image paste ',
      fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
      paste_data_images: true,
      paste_as_text: true,
      images_upload_handler: function(blobInfo, success, failure) {
        success('data:' + blobInfo.blob().type + ';base64,' + blobInfo.base64());
      },
      image_class_list: [{
        title: 'Responsive',
        value: 'img-responsive'
      }],
      setup: function(editor) {
        editor.on('change', function() {
          tinymce.triggerSave();
        });
      }
    });
  });
  </script>