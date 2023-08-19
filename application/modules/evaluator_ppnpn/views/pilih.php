<?php
      $nip = $this->m_reff->san($this->input->post("nip"));
?>

<style>
    .not_active{
        color: silver;
    }
</style>
<div class="row" id="area_pilih">
    
    <div class="col-sm-12">
        <form id="pilih" action="javascript:submitForm('pilih')" method="post" url="<?php echo base_url() ?>evaluator_ppnpn/set_evaluator">
        <div class="row clearfix">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card" > 
                    <div class="body text-black" id="body">
			
<input type="hidden" name="org" value="<?php echo $this->input->post("org");?>">

<h4>Pilih evaluator</h4><hr/>
 
    Terpilih : <?php echo $this->input->post("jml");?> Data
 <br/><hr>
 Pilih evaluator : <select name="evaluator" id="eva" class="form-control text-black" style="width:100%;color:black"></select>

                    </div>
                </div> <hr/>
            </div>

        </div>
        
        
        <button class="btn btn-primary mb-3 pull-right" onclick="javascript:submitForm('pilih')"><i class="fa fa-save"></i> SIMPAN</button>
        
    </form>
</div>
</div>


<style>
    .select2-results__option{
        color:black;
    }
    </style>
<script>
      
       $('#eva').select2({
           minimumInputLength: 3,
           dropdownParent: $('#mdl_pilih'),
           allowClear: true,
           placeholder: 'pencarian nama ....',
           ajax: {
              dataType: 'json',
              type:'POST',
              url: "<?php echo base_url()?>evaluator_ppnpn/data_pns",
              delay: 800,
              data: function(params) {
                return {
                  search: params.term
                }
              },
              processResults: function (data, page) {
              return {
                results: data
              };
            },
          }
      });
 

     
</script>

