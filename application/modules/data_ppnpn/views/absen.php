<?php
    $nip = $this->m_reff->san($this->input->post("nip"));
    $tahun = $this->m_reff->san($this->input->post("tahun"));
    $tahunberjalan = date('Y');

    $this->db->select('jenis_absen, COUNT(jenis_absen) as total');
    $this->db->where("nip", $nip);

    if($tahun){
        $this->db->where("DATE_FORMAT(tgl,'%Y')", $tahun);
    }else{
        $this->db->where("DATE_FORMAT(tgl,'%Y')", $tahunberjalan);
    }

    $this->db->group_by("jenis_absen");
    $data = $this->db->get("data_absen")->result();


    // $wfo = json_encode($data[0]->total);
    // $absen_wfo = str_replace('"',' ',$wfo);

    // $wfh = json_encode($data[1]->total);
    // $absen_wfh = str_replace('"',' ',$wfh);

    // $dinas = json_encode($data[2]->total);
    // $absen_dinas = str_replace('"',' ',$dinas);
  
?>
        <?php
        $wfo=0; $wfh = 0; $dinas = 0; $izin = 0; $sakit = 0; $cuti = 0; $alfa = 0;
            foreach($data as $absen){ ?>
            
                <?php
                    if($absen->jenis_absen == 1){
                        $wfo = $absen->total;
                    }

                    if($absen->jenis_absen == 2){
                        $wfh = $absen->total;
                    }

                    if($absen->jenis_absen == 3){
                        $dinas = $absen->total;
                    }

                    if($absen->jenis_absen == 4){
                        $izin = $absen->total;
                    }

                    if($absen->jenis_absen == 5){
                        $sakit = $absen->total;
                    }

                    if($absen->jenis_absen == 6){
                        $cuti = $absen->total;
                    }

                    if($absen->jenis_absen == 7){
                        $alfa = $absen->total;
                    }
                ?>
                
        <?php }
        ?>


<table class="table table-bordered">
    <thead>
        <tr>
            <th>WFO</th>
            <th>WFH</th>
            <th>DINAS</th>
            <th>IZIN</th>
            <th>SAKIT</th>
            <th>CUTI</th>
            <th>ALFA</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center"><?=$wfo?></td>
            <td class="text-center"><?=$wfh?></td>
            <td class="text-center"><?=$dinas?></td>
            <td class="text-center"><?=$izin?></td>
            <td class="text-center"><?=$sakit?></td>
            <td class="text-center"><?=$cuti?></td>
            <td class="text-center"><?=$alfa?></td>
        </tr>
    </tbody>
</table>