<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>Tahun Pelajaran</label>
      <input type="text"
             name="tahun_pelajaran"
             class="form-control"
             placeholder="2024/2025"
             value="{{ old('tahun_pelajaran', $data->tahun_pelajaran ?? '') }}"
             required>
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label>Semester</label>
      <select name="semester" class="form-control" required>
        <option value="">- Pilih -</option>
        <option value="Ganjil"
          @selected(old('semester',$data->semester ?? '')=='Ganjil')>
          Ganjil
        </option>
        <option value="Genap"
          @selected(old('semester',$data->semester ?? '')=='Genap')>
          Genap
        </option>
      </select>
    </div>
  </div>
</div>

<div class="form-group">
  <label>Tempat Pembagian Rapor</label>
  <input type="text"
         name="tempat_pembagian_rapor"
         class="form-control"
         value="{{ old('tempat_pembagian_rapor', $data->tempat_pembagian_rapor ?? '') }}">
</div>

<div class="form-group">
  <label>Tanggal Pembagian Rapor</label>
  <input type="date"
         name="tanggal_pembagian_rapor"
         class="form-control"
         value="{{ old('tanggal_pembagian_rapor',
           optional($data->tanggal_pembagian_rapor ?? null)->format('Y-m-d')) }}">
</div>

<div class="form-check mt-3">
  <input type="checkbox"
         name="status_aktif"
         class="form-check-input"
         id="aktif"
         @checked(old('status_aktif', $data->status_aktif ?? false))>
  <label class="form-check-label" for="aktif">
    Jadikan sebagai tahun pelajaran aktif
  </label>
</div>
