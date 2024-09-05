<div class="container">

    <!-- START FORM -->
    @if ($errors->any())
        <div class="pt-4">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    @if (session('success'))
        <div class="pt-4">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    @endif
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <form>
            <div class="mb-3 row">
                <label for="name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" wire:model="name">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" wire:model="email">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="address" class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" wire:model="address">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                    @if ($updateData == false)
                        <button type="submit" class="btn btn-primary" name="submit" wire:click="store">
                            Simpan
                        </button>
                    @else
                        <button type="submit" class="btn btn-primary" name="submit" wire:click="update">
                            Update
                        </button>
                    @endif
                    <button type="button" class="btn btn-secondary" name="submit" wire:click="clear">
                        Clear
                    </button>
                </div>
            </div>
        </form>
    </div>
    <!-- AKHIR FORM -->

    <!-- START DATA -->
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h1>Data Pegawai</h1>
        <div class="py-3">
            <input type="text" wire:model.live="keyword" name="search" id="search" class="form-control mb-3 w-25"
                placeholder="Search...">
        </div>
        <div class="pb-2">
            @if ($counterSelectedId)
                <a wire:click="deleteConfirm('')" class="btn btn-danger btn-sm px-2" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">Delete {{ count($counterSelectedId) }} data</a>
            @endif
        </div>
        {{ $dataCounter->links() }}
        <table class="table table-striped table-sortable">
            <thead>
                <tr>
                    <th></th>
                    <th class="col-md-1 sort">No</th>
                    <th class="col-md-3 sort @if ($sortColumn == 'name') {{ $sortDirection }} @endif"
                        wire:click="sort('name')">Nama
                    </th>
                    <th class="col-md-4 sort @if ($sortColumn == 'email') {{ $sortDirection }} @endif"
                        wire:click="sort('email')">Email</th>
                    <th class="col-md-2 sort @if ($sortColumn == 'address') {{ $sortDirection }} @endif"
                        wire:click="sort('address')">Alamat</th>
                    <th class="col-md-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach ($dataCounter as $key => $data)
                    <tr>
                        <td><input type="checkbox" wire:key="{{ $data->id }}" value="{{ $data->id }}"
                                name="" id="" wire:model.live="counterSelectedId"></td>
                        <td>{{ $dataCounter->firstItem() + $key }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->email }}</td>
                        <td>{{ $data->address }}</td>
                        <td class="d-flex">
                            <a wire:click="edit({{ $data->id }})" class="btn btn-warning btn-sm mx-1 px-2">Edit</a>
                            <a wire:click="deleteConfirm({{ $data->id }})" class="btn btn-danger btn-sm px-2"
                                data-bs-toggle="modal" data-bs-target="#exampleModal">Del</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $dataCounter->links() }}

    </div>
    <!-- AKHIR DATA -->
    <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Yakin dihapus nih??????? HAHAHAHA
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                    <button wire:click="delete" type="submit" class="btn btn-primary"
                        data-bs-dismiss="modal">Baiklah</button>
                </div>
            </div>
        </div>
    </div>
</div>
