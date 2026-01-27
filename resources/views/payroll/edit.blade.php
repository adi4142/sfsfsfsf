<h2>Edit Periode Penggajian</h2>
            <form action="{{route('payroll.update', $editpayroll->payroll_id)}}" method="POST">
                {{csrf_field()}}
                @method('PUT')
                <div>
                    <label for="period_month">Periode Bulan : </label>
                    <br>
                    <input type="number" name="period_month" value="{{$editpayroll->period_month}}"required>
                    <br>
                    <label for="period_year">Periode Tahun : </label>
                    <br>
                    <input type="number" name="period_year" value="{{$editpayroll->period_year}}"required>
                    <br>
                    <label for="status">Status : </label>
                    <br>
                    <select name="status">
                        <option value="">--Pilih status penggajian--</option>
                        <option value="calculated">sedang dihitung</option>
                        <option value="approved">disetujui</option>
                        <option value="paid">sudah dibayar</option>
                    </select>
                    <br>
                        <button type="submit" class="btn btn-primary">Ganti</button>
                        <a href="{{route('payroll.index')}}" class="btn btn-danger">Kembali</a>
                </div>
            </form>