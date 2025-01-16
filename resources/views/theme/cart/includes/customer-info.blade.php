@if(!empty($shippingAddress))
    <div>
      <span class="fs-ms text-muted">Tên:</span>
      <span class="fs-md fw-medium text-heading">{{ $shippingAddress['fullname'] }}</span>
    </div>
    <div>
          <span class="fs-ms text-muted">Điện thoại:</span>
          <span class="fs-md fw-medium text-heading">{{ $shippingAddress['phone'] }}</span>
    </div>
    <div>
      <span class="fs-ms text-muted">Địa chỉ:</span>
      <span class="fs-md fw-medium text-heading">{{ $shippingAddress['address_full']??'' }}</span>
    </div>
@endif