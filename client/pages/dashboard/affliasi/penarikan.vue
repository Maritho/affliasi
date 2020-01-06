<template>
  <div class="content-wrapper" style="min-height: 640px">
    <div class="content-header">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"> Penarikan</h1>
        </div>
      </div>
    </div>
    <div class="content">
      <div class="card">
        <div class="card-body">
          <Datatables :instance="datatable.instance" :columns="datatable.columns" :order="3" :ajax="datatable.ajax"
                      :footer="true"></Datatables>
        </div>
      </div>
    </div>

    <Modal title="Permintaan Penarikan" v-if="show_modal_penarikan" @close="show_modal_penarikan = false">
      <div class="modal-body">
        <div class="row mb-3">
          <div class="col-md-6">
            <div class="form-group">
              <label>Nama Blogger</label>
              <div>{{form.blogger}}</div>
            </div>
            <div class="form-group">
              <label>URL Blogger</label>
              <div>{{form.url_blog}}</div>
            </div>
            <div class="form-group">
              <label>Saldo</label>
              <div>{{form.saldo}}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Tanggal Pengajuan</label>
              <div>{{form.tanggal}}</div>
            </div>
            <div class="form-group">
              <label>Penarikan</label>
              <div>{{form.penarikan}}</div>
            </div>
          </div>
        </div>

        <div class="text-center">
          <button type="button" @click="handlerPenarikan(1)" class="btn btn-success">Setuju</button>
          <button type="button" @click="handlerPenarikan(0)" class="btn btn-danger">Tolak</button>
          <button type="button" @click="handlerPenarikan(null)" class="btn btn-secondary">Pengecekan</button>
        </div>
      </div>
    </Modal>

  </div>
</template>

<script>

  import Datatables from "../../../components/DataTable";
  import Modal from "../../../components/Modal";

  export default {
    components: {
      Datatables,
      Modal
    },
    data() {
      return {
        show_modal_penarikan: false,
        form: {
          id_penarikan: null,
          blogger: '',
          tanggal: '',
          url_blog: '',
          penarikan: 0,
          saldo: 0,
          status: ''
        },
        datatable: {
          instance: 'tableDataPenarikan',
          columns: [
            {class: 'text-center', orderable: false, searchable: false, data: 'id_penarikan', title: 'No.'},
            {data: 'name', name: 'users.name', title: 'Nama'},
            {class: 'text-center', data: 'saldo', title: 'Saldo'},
            {class: 'text-center', data: 'penarikan', title: 'Saldo'},
            {class: 'text-center', data: 'created_at', title: 'Tanggal'},
            {
              class: 'text-center', data: 'status', title: 'Status',
              render: function (data, type, row, meta) {
                if (data == '1') {
                  return '<span class="badge badge-success">Diterima</span>';
                } else if (data == 0) {
                  return '<span class="badge badge-danger">Ditolak</span>';
                } else {
                  return '<span class="badge badge-secondary">Pengecekan</span>';
                }
              }
            },
            {
              class: 'text-center', data: 'id_penarikan', title: 'Aksi', searchable: false, orderable: false,
              render: function (data, type, row, meta) {
                return '<button class="btn btn-primary btn-sm btn-secondary edit-action"><i class="fa fa-edit"></i></button>';
              }
            }
          ],
          ajax: {
            url: process.env.BASE_URL + "/penarikan/all",
            global: false,
            headers: {
              Authorization: this.$auth.getToken("local")
            }
          }
        }
      }
    },
    methods: {
      async handlerPenarikan(value) {
        this.form.status = value;
        await this.$axios.$put('/penarikan/change-status/' + this.form.id_penarikan, this.form)
          .then(response => {
            if (response.status) {
              $("#" + this.datatable.instance + "").DataTable().ajax.reload(null, false);
              this.show_modal_penarikan = false;
              this.$swal('Suksess', 'Penarikan berhasil di ubah', 'success')
            } else {
              this.$swal('Opss', response.message, 'error')
            }
          })
      },
      async editAction(id) {
        await this.$axios.$get('/penarikan/detail/' + id)
          .then(response => {
            if (response.status) {
              this.form.id_penarikan = response.result.id_penarikan;
              this.form.blogger = response.result.name;
              this.form.url_blog = response.result.url_blog;
              this.form.saldo = response.result.saldo;
              this.form.tanggal = response.result.created_at;
              this.form.penarikan = response.result.penarikan;
              this.show_modal_penarikan = true;
            } else {
              this.$swal('Opss', response.message, 'error')
            }
          })
      }
    },
    mounted() {
      const self = this;
      const dataTable = $("#" + self.datatable.instance + "").DataTable(this.parameters);

      $("tbody", this.$refs[self.datatable.instance]).on("click", ".edit-action", function () {
        const cell = dataTable.cell($(this).closest("td"));
        self.editAction(cell.data());
      });

      $("#" + self.datatable.instance + "" + ' tfoot th').each(function () {
        let title = $(this).text();
        let elem = '';

        if (title == 'No.' || title == 'Aksi') {
          elem = '';
        } else if (title == 'Status') {
          elem = '<select class="form-control form-control-sm">' +
            '<option value="">Status</option>' +
            '<option value="2">Pengecekan</option>' +
            '<option value="1">Diterima</option>' +
            '<option value="0">Ditolak</option>' +

            '</select>';
        } else {
          elem = '<input type="text" class="form-control form-control-sm" placeholder="' + title + '" />';
        }

        $(this).html(elem);

      });

      dataTable.columns().every(function () {
        var that = this;

        $('input, select', this.footer()).on('keyup change clear', function () {
          if (that.search() !== this.value) {
            that
              .search(this.value)
              .draw();
          }
        });
      });
    }
  }
</script>
