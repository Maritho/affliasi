<template>
  <div class="content-wrapper" style="min-height: 640px">
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"> Campaign Banner</h1>
          </div>
          <div class="col-sm-6">
            <button class="btn btn-primary btn-sm mt-2 pull-right" @click="show_modal_handler">Buat Campaign
              Banner
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="content">
      <div class="container">
        <div class="card">
          <div class="card-body">
            <Datatables :instance="datatable.instance" :columns="datatable.columns" :order="0" :ajax="datatable.ajax"
                        :footer="true"></Datatables>
          </div>
        </div>
      </div>
    </div>

    <Modal title="Campaign Banner" v-if="show_modal_campaign" @close="show_modal_campaign = false">
      <form @submit.prevent="validateBeforeSubmit">
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Campaign</label>
            <input type="text" class="form-control" v-model="form.nama_campaign" placeholder="Nama Campaign">
          </div>
          <div class="form-group">
            <label>Landing Page</label>
            <input type="url" class="form-control" v-model="form.landing_page" placeholder="Landing Page">
          </div>
          <div class="form-group">
            <label>Gambar Banner</label>
            <input type="file" ref="image" @change="handlePreview" class="form-control" placeholder="Gambar Banner">
          </div>
          <div class="form-group" v-if="is_preview">
            <label>Preview Gambar Banner</label>
            <img :src="is_preview" class="img-fluid">
          </div>
          <div class="form-group">
            <label>Status</label>
            <select v-model="form.status" class="form-control">
              <option value="">Status</option>
              <option value="1">Aktif</option>
              <option value="0">Nonaktif</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="show_modal_campaign = false">Batal</button>
          <button type="submit" class="btn btn-primary">{{action_modal}}</button>
        </div>
      </form>
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
        action_modal: 'Buat Campaign Banner',
        show_modal_campaign: false,
        is_preview: false,
        form: {
          id: null,
          nama_campaign: '',
          landing_page: '',
          status: '',
        },
        datatable: {
          instance: 'tableDataCampaign',
          columns: [
            {class: 'text-center', orderable: false, searchable: false, data: 'id', title: 'No.'},
            {data: 'name', title: 'Nama Campaign'},
            {
              data: 'landing_page', title: 'Landing Page',
              render: function (data, type, row, meta) {
                return '<a href="' + data + '">' + data + '</a>';
              }
            },
            {class: 'text-center', data: 'created_at', title: 'Tanggal Ditambahkan'},
            {class: 'text-center', data: 'user_name', name: 'users.name', title: 'Ditambah Oleh'},
            {
              class: 'text-center', data: 'status', name: 'status', title: 'Status',
              render: function (data, type, row, meta) {
                if (data == 1) {
                  return '<span class="badge badge-success">Aktif</span>';
                } else {
                  return '<span class="badge badge-danger">Nonaktif</span>';
                }
              }
            },
            {
              class: 'text-center', data: 'id', title: 'Aksi',
              render: function (data, type, row, meta) {
                return '<button class="btn btn-primary btn-sm btn-secondary edit-action"><i class="fa fa-edit"></i></button>' +
                  '<button class="btn btn-primary btn-sm btn-danger delete-action"><i class="fa fa-trash-o"></i></button>';
              }
            }
          ],
          ajax: {
            url: process.env.BASE_URL + "/campaign/all",
            global: false,
            headers: {
              Authorization: this.$auth.getToken("local")
            }
          }
        }
      }
    },
    methods: {
      show_modal_handler() {
        this.is_preview = false;
        this.action_modal = 'Buat Campaign Banner';
        this.show_modal_campaign = true;
      },
      handlePreview(e) {
        this.is_preview = URL.createObjectURL(e.target.files[0]);
      },
      async validateBeforeSubmit() {
        let form = new FormData();
        form.append('id', this.form.id);
        form.append('image', this.$refs.image.files[0]);
        form.append('nama_campaign', this.form.nama_campaign);
        form.append('landing_page', this.form.landing_page);
        form.append('status', this.form.status);

        if (this.action_modal == 'Buat Campaign Banner') {
          await this.$axios.$post('/campaign/add', form)
            .then(response => {
              if (response.status) {
                this.$swal('Sukses', 'Campaign banner berhasil ditambahkan', 'success')
                this.show_modal_campaign = false;
                $("#" + this.datatable.instance + "").DataTable().ajax.reload(null, false);
              } else {
                this.$swal('Opss', response.message, 'error')
              }
            })
        } else {
          await this.$axios.$post('/campaign/update', form)
            .then(response => {
              if (response.status) {
                this.$swal('Sukses', 'Campaign banner berhasil diubah', 'success')
                this.show_modal_campaign = false;
                $("#" + this.datatable.instance + "").DataTable().ajax.reload(null, false);
              } else {
                this.$swal('Opss', response.message, 'error')
              }
            })
        }
      },
      async editAction(id) {
        this.action_modal = 'Ubah Campaign Banner';
        await this.$axios.$get('/campaign/detail/'+id)
          .then(response => {
            if (response.status) {
                this.form.id = response.result.id;
                this.form.nama_campaign = response.result.name;
                this.form.landing_page = response.result.landing_page;
                this.form.status = response.result.status;
                this.is_preview = response.result.image
              this.show_modal_campaign = true;
            } else {
              this.$swal('Opss', response.message, 'error')
            }
          })
      },
      async deleteAction(id) {
        this.$swal({
          title: "Apakah anda yakin?",
          text: "Anda tidak akan dapat membatalkan tindakan ini",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
          .then((willDelete) => {
            if (willDelete) {
              this.$axios.$delete('/campaign/' + id)
                .then(response => {
                  if (response.status) {
                    swal("Sukses", "Campaign berhasil dihapus", "success");
                    $("#" + this.datatable.instance + "").DataTable().ajax.reload(null, false);
                  } else {
                    this.$swal('Opss', response.message, 'error')
                  }
                })
            }
          });
      }
    },
    mounted() {
      const self = this;
      const dataTable = $("#" + self.datatable.instance + "").DataTable(this.parameters);

      $("tbody", this.$refs[self.datatable.instance]).on("click", ".edit-action", function () {
        const cell = dataTable.cell($(this).closest("td"));
        self.editAction(cell.data());
      });

      $("tbody", this.$refs[self.datatable.instance]).on("click", ".delete-action", function () {
        const cell = dataTable.cell($(this).closest("td"));
        self.deleteAction(cell.data());
      });

      $("#" + self.datatable.instance + "" + ' tfoot th').each(function () {
        let title = $(this).text();
        let elem = '';

        if (title == 'No.' || title == 'Aksi') {
          elem = '';
        } else if (title == 'Status') {
          elem = '<select class="form-control form-control-sm">' +
            '<option value="">Semua</option>' +
            '<option value="1">Aktif</option>' +
            '<option value="0">Nonaktif</option>' +
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
