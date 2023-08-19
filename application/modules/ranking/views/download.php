<style>
	#table{
		font-family: Arial, Helvetica, sans-serif;
	}
	#tabelAtas, td{
		font-size: 11px;
		padding: 5 5px 5 5px;
    }
	#tabelBawah{
		font-size: 11px;
	}
	 
	#table, th, #table td{
		border: 1px solid black;
		border-collapse: collapse;
	}
</style>



<?php
// echo $nip;
$db = $this->db->get_where("penilaian_kinerja_ppnpn",array("id"=>$id))->row();
$nip = isset($db->nip)?($db->nip):null;
if(!$nip){
echo "Data tidak tersedia";
return false;
}


$evaluator   =   isset($db->evaluator)?($db->evaluator):null;
$semester    =   isset($db->semester)?($db->semester):null;
$tahun       =   isset($db->tahun)?($db->tahun):null;
$hasil_evaluasi       =   isset($db->hasil_evaluasi)?($db->hasil_evaluasi):null;
$hasil_penilaian      =   isset($db->data_penilaian)?($db->data_penilaian):null;
$predikat   = isset($db->predikat)?($db->predikat):null;
$predikat   = $this->m_reff->predikat($predikat);
$komentar   = isset($db->komentar)?($db->komentar):null;
$created   = isset($db->created_at)?($db->created_at):null;
$created   = substr($created,0,10);
$created   = $this->tanggal->ind_bulan($created," ");

$dtNilai = json_decode($hasil_penilaian,TRUE);
$hasil = "";
foreach($dtNilai as $key=>$val){
    $hasil.= "<tr>
    <td>".ucwords(strtolower($val['indikator']))."</td>
    <td>:</td>
    <td>".number_format($val['skor'],2,",",".")."</td>
    <td>".number_format($val['nilai'],2,",",".")."</td>
    </tr>";
}


$db = $this->m_reff->data_pegawai($evaluator);
$nama_eva = isset($db->nama)?($db->nama):"";
$nip_eva = isset($db->nip)?($db->nip):"";
$jabatan_eva = isset($db->jabatan)?($db->jabatan):"";

$dok=$this->m_reff->pengaturan(1)."dok/".$nip_eva."/ttd.jpg";
$img = $this->konversi->img($dok);
if($img){
    $ttd='<img style="height:50px;float:right" src="'.$img.'"/>';
}else{
    $ttd="<br><br><br>";
}


if($semester==1){
    $periode = "Periode 1 Januari s.d 30 Juni ".$tahun;
}else{
    $periode = "Periode 1 Juli s.d 31 Desember ".$tahun;
}

$db = $this->m_reff->data_pegawai($nip);
$istana = isset($db->kode_istana)?($db->kode_istana):null;
$nama   = isset($db->nama)?($db->nama):null;
$nip   = isset($db->nip)?($db->nip):null;
$bagian   = isset($db->bagian)?($db->bagian):null;
$subbagian   = isset($db->subbagian)?($db->subbagian):null;
$jabatan   = isset($db->jabatan)?($db->jabatan):null;
// print_r($db);
if($bagian){
    $pengguna = $bagian;
}else{
    $pengguna = $subbagian;
}

$this->db->where("kode",$istana);
$db	=	$this->db->get("tr_istana")->row();
if(!isset($db)){
	echo "data istana tidak ditemukan";
	return false;
}


$imgNull=base_url().'plug/img/kop-surat.jpg';
$imgPath=base_url().'plug/img/';
$nama_istana=isset($db->istana)?($db->istana):'';	

$imgdata=isset($db->header)?($db->header):'';	
$dok=$this->m_reff->pengaturan(1)."dok/".$imgdata;
$dok = $this->konversi->img($dok);
if(!$dok){
	$kop_surat=base_url().'plug/img/kop-surat.jpg';
}else{
	$kop_surat=$dok;
}

?>

<img src="<?=$kop_surat;?>" style="width:100%"/>
<p align="center">
 <b>
EVALUASI KINERJA PEGAWAI OUTSOURCING SWA KELOLA <br>
 <?=strtoupper($nama_istana);?>
</b>
</p>

<p align="right">
<?=$periode;?>
</p>

<table width="100%" id="table">
    <tr>
        <td colspan="4"> <b>EVALUATOR</b></td>
    </tr>
    <tr>
        <td width="150px">Nama</td> <td width="10px">:</td><td colspan="2"> <?=$nama_eva;?></td>
    </tr>
    <tr>
        <td width="150px">NIP</td> <td width="10px">:</td><td colspan="2"> <?=$nip_eva;?></td>
    </tr>
    <tr>
        <td width="150px">Jabatan</td> <td width="10px">:</td><td colspan="2"> <?=$jabatan_eva;?></td>
    </tr>
    <tr><td colspan="4"></td></tr>
    <tr>
        <td colspan="4"> <b>PEGAWAI OUTSOURCHING SWAKELOLA</b></td>
    </tr>
   
    <tr>
        <td>Nama</td><td>:</td><td colspan="2"><?=$nama;?></td>
    </tr>
    <tr>
        <td>NPP</td><td>:</td><td colspan="2"><?=$nip;?></td>
    </tr>
    <tr>
        <td>Tugas</td><td>:</td><td colspan="2"><?=$jabatan;?></td>
    </tr>
    <tr>
        <td>Pengguna</td><td>:</td><td colspan="2"><?=$pengguna;?></td>
    </tr>
 
    <tr>
        <td width="150px" colspan="4"><b>Hasil evaluasi</b></td>
    </tr>
    <tr>
        <td>Indikator</td><td>:</td><td>Nilai Skor</td> <td>Nilai Bobot</td>
    </tr>
    <?=$hasil;?>
    <tr>
        <td colspan="3" align="right"><b> Nilai akhir</b></td> <td><b> <?=number_format($hasil_evaluasi,2,",",".");?></b></td>
    </tr>
    <tr>
        <td  colspan="3" align="right"><b>Predikat</b></td> <td><b><?=$predikat;?></b></td>
    </tr>
    <tr>
        <td colspan="4"></td>
    </tr>
    <tr>
        <td colspan="4">Komentar dan Saran Pengembangan Kompetensi dan Peningkatan Kinerja:<br><?=$komentar;?></td>
    </tr>

    
</table>

<br/>

<table width="100%">
    <tr>
        <td width="70%">
            Pegawai yang dinilai
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            ( <?=$nama;?> )
        </td>
     
        <td  >
            <?=str_replace("Kepresidenan","",$nama_istana);?>, <?=$created;?><br>
          
 
            Evaluator  <br/><br/>
             <?=$ttd;?><br/>
            ( <?=$nama_eva;?> )

            
        </td>
    </tr>
</table>