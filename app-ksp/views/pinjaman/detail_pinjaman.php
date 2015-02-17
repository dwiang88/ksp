<div class="container-fluid fixed">
	<div id="content">
<div class="separator"></div>
<div class="widget widget-4 widget-body-white">
	<div class="heading-buttons">
		<?php 
				$pinjaman = $this->mdb->getPinjaman($kode);
				foreach ($pinjaman as $key); 
				echo '<table>';
				echo '<tr><td>NO. ANGGOTA </td><td>: <b>'.$key->kode.'</b></td> <td>TANGGAL PINJAM</td><td>: <b>'.$key->tanggal.'</b></td> </tr>';
				echo '<tr><td> NAMA </td><td>: <b>'.$key->nama.'</b></td> <td>JENIS PINJAM</td><td>: <b>'.$key->jenis.'</b></td> </tr>';
				echo '<tr><td> DEPARTEMEN </td><td>: <b>'.$key->departemen.'</b></td> <td>JUMLAH PINJAM</td><td>: <b> Rp. '.buatrp($key->jumlah).'</b></td> </tr>';
				echo '<tr><td>TANGGAL MASUK </td><td>: <b>'.$key->tgl_masuk.'</b></td> <td>LAMA PINJAM</td><td>: <b>'.$key->lama.' x </b></td> </tr>';
				echo '</table>';
		?>
	</div>
	<div class="widget-body" style="padding: 10px 0 0;">
<!-- ITUNG -->

<?php

$pinjam = $key->jumlah;
$bunga = 1.65/100;
$angsur = $key->lama;
$angsuran = $pinjam/$angsur;

// $selisih_koma = min(($pinjam%$angsur), ($angsur-($pinjam%$angsur)));
function fbuatrp($angka){
        $jadi = "Rp " . number_format($angka,0,',',',');
        return $jadi;
}

?>
<div style="float:left;">
<table style="width: 600px;" class="table table-striped table-bordered table-primary table-condensed">
	<thead>
	<tr>
		<th>No</th>
		<th>Angsuran</th>
		<th>Jasa Uang</th>
		<th>Total Bayar</th>
		<th>Saldo</th>
		<th>Status</th>
	</tr>
	</thead>
	<tbody>


<?php
$saldo = array();
$saldo[0] = $pinjam;
$total_jasa = $total_angsuran = $total_bayar = 0;

for ($i=0; $i <= $angsur ; $i++) 
{ 
if($i>0) $jasa = $saldo[$i-1]*$bunga;
if($i>0) $bayar = $angsuran+$jasa;

?>
	<tr>
		<td><?=$i?></td>
		<td style="text-align:right"><?php if($i>0) echo fbuatrp(round($angsuran))?></td>
		<td style="text-align:right"><?php if($i>0) echo fbuatrp(round($jasa))?></td>
		<td style="text-align:right"><?php if($i>0) echo fbuatrp(round($bayar))?></td>
		<td style="text-align:right">
			<?php 
			if($saldo[$i]>0){ echo fbuatrp(round($saldo[$i])); } else { echo '('.fbuatrp(round($saldo[$i]*(-1))).')';}
			// echo round($saldo[$i]);
			?>
		</td>
		<td><?php if($i<=$key->status && $i!=0) echo 'LUNAS' ?></td>
	</tr>

<?php 
 $saldo[$i+1] = $saldo[$i]-$angsuran;
 if($i>0) $total_jasa += $jasa; 
 if($i>0) $total_angsuran += $angsuran; 
 if($i>0) $total_bayar += $bayar; 
}
?>
<tr>
	<td></td>
	<td style="text-align:right"><b><?=fbuatrp($total_angsuran)?></b></td>
	<td style="text-align:right"><b><?=fbuatrp($total_jasa)?></b></td>
	<td style="text-align:right"><b><?=fbuatrp($total_bayar)?></b></td>
	<td></td>
</tr>
</tbody>
</table>

</div>
<div>
<table style="width: 300px;padding-left:20px" class="table table-striped table-bordered table-primary table-condensed">
	<thead>
	<tr>
		<th colspan="3">SUMMARY</th>
	</tr>
	</thead>
	<tbody>
		<tr>
			<td><b>DIPINJAM</b></td>
			<td style="text-align:right"><?=fbuatrp($pinjam)?></td>
		</tr>
		<tr>
			<td><b>BUNGA</b></td>
			<td style="text-align:right"><?=fbuatrp($total_jasa)?></td>
		</tr>
		<tr>
			<td><b>DIBAYAR</b></td>
			<td style="text-align:right"><?=fbuatrp($total_bayar)?></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td><b>% TOTAL</b></td>
			<td style="text-align:right"><?php
			$persen_total = $total_jasa/$pinjam*100;
			echo round($persen_total, 2);
			?></td>
		</tr>
		<tr>
			<td><b>% / TAHUN</b></td>
			<td style="text-align:right">
				<?php
					if($angsur>12)
					{
						echo round($persen_total/($angsur/12), 2);
					}
					else
					{
						echo '0';
					}
				?>
			</td>
		</tr>

	</tbody>
</table>
</div>

<!-- END ITUNG -->
	</div>
</div>
			<?php 
				function buatrp($angka){
        			$jadi = number_format($angka,0,',','.');
    	    		return $jadi;
    			}	
			?>
