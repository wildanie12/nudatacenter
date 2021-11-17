@extends('argon.main')


@section('content')

<header class="bg-blue py-6"></header>
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header py-2 px-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                            <h3 class="card-title mb-0 mr-4">Daftar Anggota</h3>
                        </div>
                        <div class="col">
                            <div class="row align-items-center">
                                <div class="col-md pl-md-1 pr-md-1">
                                    <div class="form-group mb-0">
                                        <label>Nama</label>
                                        <div class="input-group input-group-sm input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-search"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm filter-nama" placeholder="Cari nama disini...">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 pl-md-1 pr-md-1">
                                    <div class="form-group mb-0">
                                        <label>Jabatan</label>
                                        <div class="input-group input-group-sm input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-user-tie"></i>
                                                </span>
                                            </div>
                                            <select class="form-control form-control-sm filter-jabatan_nu">
                                                <option value="">---</option>
                                                @foreach ($dataJabatan as $jabatan)
                                                    <option value="{{ $jabatan->jabatan_nu }}">{{ $jabatan->jabatan_nu }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 pl-md-1 pr-md-1">
                                    <div class="form-group mb-0">
                                        <label>Aktifitas NU</label>
                                        <div class="input-group input-group-sm input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-sitemap"></i>
                                                </span>
                                            </div>
                                            <select class="form-control form-control-sm filter-aktifitas_nu">
                                                <option value="">---</option>
                                                @foreach ($dataAktifitas as $aktifitas)
                                                    <option value="{{ $aktifitas->aktifitas_nu }}">{{ $aktifitas->aktifitas_nu }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-2 pl-md-1">
                                    <div class="form-group mb-0">
                                        <label for="limit">Limit baris</label>
                                        <div class="input-group input-group-merge input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-list"></i>
                                                </span>
                                            </div>
                                            <input type="number" value="50" min="0" max="500" step="5" class="form-control form-control-sm filter-limit">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="progress mb-0" style="visibility: hidden">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%"></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered table-flush yajra-datatable">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Tempat Lahir & Asal</th>
                                <th>Aktifitas NU</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="load-data">
                        </tbody>
                    </table>
                </div>
                <div class="card-footer load-pagination d-flex justify-content-end align-items-center">
                    <nav>
                        <ul class="pagination justify-content-end">
                            <li class="page-item disabled">
                                <a href="#" class="page-link" tabindex="-1">
                                    <i class="fas fa-angle-left"></i>
                                </a>
                            </li>
                            <li class="page-item"><a href="#" class="page-link">1</a></li>
                            <li class="page-item active"><a href="#" class="page-link">2</a></li>
                            <li class="page-item"><a href="#" class="page-link">3</a></li>
                            <li class="page-item">
                                <a href="#" class="page-link">
                                    <i class="fas fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection()


@section('js_scripts')
<script>
    $(document).ready(function () {
        let dataParams = {
            limit: 50
        }
        function refreshData(link) {
            if (link === undefined) link = "{{ route('admin.data_anggota.list') }}"
            $(".progress").css('visibility', 'visible')
            $.ajax({
                type: "GET",
                url: link,
                dataType: "json",
                data: dataParams
            })
            .done(function (data) {
                $("#load-data").html(data.content)
                $(".load-pagination").html(data.pagination)
                onLoadData();
            })
            .always(function () {
                $(".progress").css('visibility', 'hidden')
                $("[data-toggle='tooltip']").one().tooltip()
            })
        }
        refreshData()
        function onLoadData() {
            $(".pagination a").click(function (e) {
                e.preventDefault();
                link = $(this).attr('href')
                refreshData(link)
            })
        }

        $(".filter-nama").on('input', function(e) {
            value = $(this).val()
            if (value != '')
                dataParams.nama = value
            else 
                delete dataParams.nama
            refreshData()
        })
        $(".filter-jabatan_nu").change(function(e) {
            value = $(this).val()
            if (value != '')
                dataParams.jabatan_nu = value
            else 
                delete dataParams.jabatan_nu
            refreshData()
        })
        $(".filter-aktifitas_nu").change(function(e) {
            value = $(this).val()
            if (value != '')
                dataParams.aktifitas_nu = value
            else 
                delete dataParams.aktifitas_nu
            refreshData()
        })
        $(".filter-limit").change(function(e) {
            value = $(this).val()
            if (value != '')
                if (value > 0)
                    dataParams.limit = value
                else
                    $(this).value(50)
            else 
                delete dataParams.limit
            refreshData()
        })
    });
</script>
@endsection