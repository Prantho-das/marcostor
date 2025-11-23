@php
$pathaoCourierId = 1;
$storeId = env('PATHAO_STORE_ID'); // Your actual store ID
@endphp

<!-- Pathao Order Modal -->
<div class="modal fade" id="pathaoOrderModal" tabindex="-1" aria-labelledby="pathaoOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="pathaoOrderForm" method="POST" action="{{ url('admin/delivery/pathao/orders') }}">
            @csrf
            <input type="hidden" name="courier_id" value="{{ $pathaoCourierId }}">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pathaoOrderModalLabel">Create Pathao Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {{-- City Select --}}
                    <div class="mb-3">
                        <label for="city_id" class="form-label">City</label>
                        <select id="city_id" name="city_id" class="form-select" required>
                            <option value="">Select City</option>
                            {{-- dynamically loaded --}}
                        </select>
                    </div>

                    {{-- Zone Select --}}
                    <div class="mb-3">
                        <label for="zone_id" class="form-label">Zone</label>
                        <select id="zone_id" name="zone_id" class="form-select" required disabled>
                            <option value="">Select Zone</option>
                        </select>
                    </div>

                    {{-- Area Select --}}
                    <div class="mb-3">
                        <label for="area_id" class="form-label">Area</label>
                        <select id="area_id" name="area_id" class="form-select" required disabled>
                            <option value="">Select Area</option>
                        </select>
                    </div>

                    {{-- Recipient Info --}}
                    <div class="mb-3">
                        <label for="recipient_name" class="form-label">Recipient Name</label>
                        <input type="text" id="recipient_name" name="recipient_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="recipient_phone" class="form-label">Recipient Phone</label>
                        <input type="tel" id="recipient_phone" name="recipient_phone" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="recipient_address" class="form-label">Recipient Address</label>
                        <textarea id="recipient_address" name="recipient_address" class="form-control" rows="2"
                            required></textarea>
                    </div>

                    {{-- Delivery Type --}}
                    <div class="mb-3">
                        <label for="delivery_type" class="form-label">Delivery Type</label>
                        <select id="delivery_type" name="delivery_type" class="form-select" required>
                            <option value="48">Normal Delivery (48 hrs)</option>
                            <option value="12">On Demand Delivery (12 hrs)</option>
                        </select>
                    </div>

                    {{-- Item Type --}}
                    <div class="mb-3">
                        <label for="item_type" class="form-label">Item Type</label>
                        <select id="item_type" name="item_type" class="form-select" required>
                            <option value="1">Document</option>
                            <option value="2">Parcel</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="item_quantity" class="form-label">Item Quantity</label>
                        <input type="number" id="item_quantity" name="item_quantity" class="form-control" min="1"
                            value="1" required>
                    </div>

                    <div class="mb-3">
                        <label for="item_weight" class="form-label">Item Weight (kg)</label>
                        <input type="number" id="item_weight" name="item_weight" class="form-control" min="0.5"
                            step="0.1" value="0.5" required>
                    </div>

                    <div class="mb-3">
                        <label for="amount_to_collect" class="form-label">Amount to Collect (৳)</label>
                        <input type="number" id="amount_to_collect" name="amount_to_collect" class="form-control"
                            min="0" value="0" required>
                    </div>

                    <div class="mb-3">
                        <label for="item_description" class="form-label">Item Description</label>
                        <textarea id="item_description" name="item_description" class="form-control"
                            rows="2"></textarea>
                    </div>

                    <input type="hidden" name="merchant_order_id" value="{{ 'ORD' . time() }}">
                    <input type="hidden" name="store_id" value="{{ $storeId }}">
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit Order</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const courier = 'pathao';
    const citySelect = document.getElementById('city_id');
    const zoneSelect = document.getElementById('zone_id');
    const areaSelect = document.getElementById('area_id');

    // Elements for pre-fill recipient info from page
    const orderPhone = document.getElementById('orderPhone')?.textContent || '';
    const orderName = document.getElementById('orderName')?.textContent || '';
    const orderAddress = document.getElementById('orderAddress')?.textContent || '';

    // When modal opens, load cities and fill recipient info
    var modal = document.getElementById('pathaoOrderModal');
    modal.addEventListener('show.bs.modal', function () {
      // Pre-fill recipient fields
      document.getElementById('recipient_phone').value = orderPhone;
      document.getElementById('recipient_name').value = orderName;
      document.getElementById('recipient_address').value = orderAddress;

      // Fetch cities
      fetch(`/admin/delivery/${courier}/cities`)
        .then(res => res.json())
        .then(data => {
          citySelect.innerHTML = '<option value="">Select City</option>';
          data?.data?.forEach(city => {
            citySelect.insertAdjacentHTML('beforeend', `<option value="${city.city_id}">${city.city_name}</option>`);
          });
          zoneSelect.innerHTML = '<option value="">Select Zone</option>';
          zoneSelect.disabled = true;
          areaSelect.innerHTML = '<option value="">Select Area</option>';
          areaSelect.disabled = true;
        });
    });

    citySelect.addEventListener('change', function () {
      const cityId = this.value;
      if (!cityId) {
        zoneSelect.innerHTML = '<option value="">Select Zone</option>';
        zoneSelect.disabled = true;
        areaSelect.innerHTML = '<option value="">Select Area</option>';
        areaSelect.disabled = true;
        return;
      }
      fetch(`/admin/delivery/${courier}/zones/${cityId}`)
        .then(res => res.json())
        .then(data => {
          zoneSelect.innerHTML = '<option value="">Select Zone</option>';
          data?.data?.forEach(zone => {
            zoneSelect.insertAdjacentHTML('beforeend', `<option value="${zone.zone_id}">${zone.zone_name}</option>`);
          });
          zoneSelect.disabled = false;
          areaSelect.innerHTML = '<option value="">Select Area</option>';
          areaSelect.disabled = true;
        });
    });

    zoneSelect.addEventListener('change', function () {
      const zoneId = this.value;
      if (!zoneId) {
        areaSelect.innerHTML = '<option value="">Select Area</option>';
        areaSelect.disabled = true;
        return;
      }
      fetch(`/admin/delivery/${courier}/areas/${zoneId}`)
        .then(res => res.json())
        .then(data => {
          areaSelect.innerHTML = '<option value="">Select Area</option>';
          data?.data?.forEach(area => {
            areaSelect.insertAdjacentHTML('beforeend', `<option value="${area.area_id}">${area.area_name}</option>`);
          });
          areaSelect.disabled = false;
        });
    });
  });
</script>
@endpush