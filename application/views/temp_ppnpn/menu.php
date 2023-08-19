<div id="footer-bar" class="footer-bar-5">
<a href="<?php echo base_url()?>pengumuman/informasi"><i class="fa fa-newspaper font-16 color-mint-light"></i><span>Pengumuman</span></a>
<a href="javascript:reload(`<?php echo base_url()?>absen`)"><i class="fa fa-address-book font-16 color-blue2-dark"></i><span>Rekap absen</span></a>
<a href="javascript:reload(`<?php echo base_url()?>home`)" class="active-navs"><i class="fa fa-home font-16 color-red2-dark"></i><span>Home</span></a>
<a href="javascript:reload(`<?php echo base_url()?>penilaian_front`)"><i class="fa fa-calendar-check font-16 color-green2-dark"></i> <span>Penilaian</span></a>
<a href="javascript:reload(`<?php echo base_url()?>up`)"><i class="fa fa-universal-access font-16 color-magenta2-dark"></i><span>  Profile</span></a>
</div>

<script>
function reload(url){
	window.location.href=url;
}
</script>