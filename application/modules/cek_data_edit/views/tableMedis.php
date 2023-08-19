<div class="table-responsive">
    <table class="entry2 mb-4" width="100%" font="9px">
        <thead>
            <tr>
                          <th>No</th>
                          <th>Tgl MCU</th>
                          <th>Kesimpulan</th>
                          <th>Saran tindak lanjut</th> 
                          <th>File hasil MCU</th> 
                       
                <th>Edit | Hapus</th>
            </tr>
        </thead>
        <tbody>
            <?php $n = 1;
            $h = $this->mdl->getMedisByNip($val)->result();
            foreach ($h as $val) {
                if($val->file_mcu){
                    $file  =  $this->m_reff->encrypt($val->file_mcu);
                $file_mcu =  ' <a  href="'.base_url().'download?f='.$file.'" class="text-info btn-block"><i class="fa fa-file"></i> Hasil mcu</a>';
                 }else{
                  $file_mcu = "-";
                 }
                     
                    echo '
                    <tr>
                    <td>'.$n++.'</td>
                    <td>'.$val->tgl_mcu.'</td>
                    <td>'.$val->kesimpulan.'</td>
                    <td>'.$val->saran.'</td>
                    <td>'.$file_mcu.'</td>
                    <td>
                    <a href="#" onclick="formTableEdit('.$val->id.')" title="Edit" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                    <a href="#" onclick="hapusTable('.$val->id.')" title="Hapus" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a></td>
                </tr>';
             } ?>
        </tbody>
    </table>
</div>