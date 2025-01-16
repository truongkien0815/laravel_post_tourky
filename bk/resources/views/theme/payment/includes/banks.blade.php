@php
	$bank_code = $bank_code??'';
@endphp
<div class="select-include">
	<div class="banklist mt-3">
		<label class="mb-2">Bạn hãy chọn ngân hàng <span class="redcolor">*</span></label>
		<br>

		<div class="d-flex flex-wrap">
			<label>
				<input type="radio" name="bank_code" value="VIETCOMBANK"   {{ $bank_code == 'VIETCOMBANK' ? 'checked' : '' }}>
				<div class="img">
					<img src="{{ asset('assets/images/banks/bank-vcb.png') }}" title="Ngân hàng Ngoại thương (Vietcombank)">
				</div>
			</label>
			<label>
				<input type="radio" name="bank_code" value="SCB"  {{ $bank_code == 'SCB' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-scb.png') }}" title="Ngân hàng TMCP Sài Gòn (Sai Gon Commercial Bank)">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="KLB" {{ $bank_code == 'KLB' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-kienlong.png') }}" rel="KLB" title="KienLongBank">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="NCB" {{ $bank_code == 'NCB' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-ncb.png') }}" rel="NCB" title="Ngân hàng Quốc dân (NCB)">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="TECHCOMBANK" {{ $bank_code == 'TECHCOMBANK' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-techcom.png') }}" rel="TECHCOMBANK" title="Ngân hàng Kỹ thương Việt Nam (TechcomBank)">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="VIETINBANK" {{ $bank_code == 'VIETINBANK' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-vietin.png') }}" rel="VIETINBANK" title="Ngân hàng Công thương (Vietinbank)">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="BIDV" {{ $bank_code == 'BIDV' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-bidv.png') }}" rel="BIDV" title="Ngân hàng đầu tư và phát triển Việt Nam (BIDV)">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="MSBANK" {{ $bank_code == 'MSBANK' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-maritime.png') }}" rel="MSBANK" title="Ngân hàng Hàng Hải (Maritime Bank)">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="OJB" {{ $bank_code == 'OJB' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-ocean.png') }}" rel="OJB" title="Ngân hàng Đại Dương (OceanBank)">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="VPBANK" {{ $bank_code == 'VPBANK' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-vp.png') }}" rel="VPBANK" title="Ngân hàng Việt Nam Thịnh vượng (VPBank)">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="DONGABANK" {{ $bank_code == 'DONGABANK' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-donga.png') }}" rel="DONGABANK" title="Ngân hàng Đông Á (DongABank)">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="ACB" {{ $bank_code == 'ACB' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-acb.png') }}" rel="ACB" title="Ngân hàng ACB">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="SACOMBANK" {{ $bank_code == 'SACOMBANK' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-sacom.png') }}" rel="SACOMBANK" title="Ngân hàng TMCP Sài Gòn Thương Tín (SacomBank)">
			</div></label>

			<label>
				<input type="radio" name="bank_code" value="SACOMBANK" {{ $bank_code == 'SACOMBANK' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-mb.png') }}" rel="MB" title="MBBank">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="AGRIBANK" {{ $bank_code == 'AGRIBANK' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-agri.png') }}" rel="AGRIBANK" title="Ngân hàng Nông nghiệp (Agribank)">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="VIB" {{ $bank_code == 'VIB' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-vib.png') }}" rel="VIB" title="VIB Bank">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="TPBANK" {{ $bank_code == 'TPBANK' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-tp.png') }}" rel="TPBANK" title="Ngân hàng Tiên Phong (TPBank)">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="EXIMBANK" {{ $bank_code == 'EXIMBANK' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-exim.png') }}" rel="EXIMBANK" title="Ngân hàng EximBank">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="SHB" {{ $bank_code == 'SHB' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-shb.png') }}" rel="SHB" title="Ngân hàng Thương mại Cổ phần Sài Gòn - Hà Nội">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="SEAB" {{ $bank_code == 'SEAB' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-sea.png') }}" rel="SEAB" title="SeaBank">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="BVB" {{ $bank_code == 'BVB' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-baoviet.png') }}" rel="BVB" title="BaoVietBank">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="LPB" {{ $bank_code == 'LPB' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-lienviet.png') }}" rel="LPB" title="LienVietPostBank">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="ABBANK" {{ $bank_code == 'ABBANK' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-ab.png') }}" rel="ABBANK" title="Ngân hàng TMCP An Bình">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="OCB" {{ $bank_code == 'OCB' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-ocb.png') }}" rel="OCB" title="Ngân hàng Phương Đông (OricomBank)">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="HDBANK" {{ $bank_code == 'HDBANK' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-hd.png') }}" rel="HDBANK" title="Ngan hàng HDBank">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="NAMABANK" {{ $bank_code == 'NAMABANK' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-nama.png') }}" rel="NAMABANK" title="Ngân hàng Nam Á (NamABank)" class="active">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="VAB" {{ $bank_code == 'VAB' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-vieta.png') }}" rel="VAB" title="VietABank">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="GPB" {{ $bank_code == 'GPB' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-gp.png') }}" rel="GPB" title="GPBank">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="NASB" {{ $bank_code == 'NASB' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-baca.png') }}" rel="NASB" title="BacABank">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="NVB" {{ $bank_code == 'NVB' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-navi.png') }}" rel="NVB" title="Navibank">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="IVB" {{ $bank_code == 'IVB' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-ivb.png') }}" rel="IVB" title="Ngân hàng TNHH Indovina (IVB)">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="VNMART" {{ $bank_code == 'VNMART' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-vnmart.png') }}" rel="VNMART" title="Ví điện tử VnMart">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="VIETCAPITALBANK" {{ $bank_code == 'VIETCAPITALBANK' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-vietcapital.png') }}" rel="VIETCAPITALBANK" title="Ngân Hàng Bản Việt	">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="PVCOMBANK" {{ $bank_code == 'PVCOMBANK' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-pvcom.png') }}" rel="PVCOMBANK" title="Ngân hàng TMCP Đại Chúng Việt Nam (PV Combank)">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="SAIGONBANK" {{ $bank_code == 'SAIGONBANK' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-saigon.png') }}" rel="SAIGONBANK" title="Ngân hàng thương mại cổ phần Sài Gòn Công Thương">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="PGB" {{ $bank_code == 'PGB' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-pg.png') }}" rel="PGB" title="Ngân hàng TMCP Xăng dầu Petrolimex (PG Bank)">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="VRB" {{ $bank_code == 'VRB' ? 'checked' : '' }}>
				<div class="img">
				<img src="{{ asset('assets/images/banks/bank-vr.png') }}" rel="VRB" title="Ngân hàng Liên doanh Việt - Nga">
			</div></label>
			<label>
				<input type="radio" name="bank_code" value="PBVN" {{ $bank_code == 'PBVN' ? 'checked' : '' }}>
				<div class="img">
					<img src="{{ asset('assets/images/banks/bank-pub.png') }}" rel="PBVN" title="Ngân hàng Public Bank Việt Nam">
				</div>
			</label>

		</div>
	</div>
</div>