<template>
  <div class="content-wrapper" style="min-height: 640px">
    <div class="content-header">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"> Blogger</h1>
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
        datatable: {
          instance: 'tableDataBlogger',
          columns: [
            {class: 'text-center', orderable: false, searchable: false, data: 'id_user', title: 'No.'},
            {data: 'name', title: 'Nama'},
            {
              data: 'url_blog', name: 'blogs.url_blog', title: 'URL Blog',
              render: function (data, type, row, meta) {
                return '<a href="' + data + '">' + data + '</a>';
              }
            },
            {
              class: 'text-center', data: 'id_user', title: 'Status',
              render: function (data, type, row, meta) {
                if (row.status == 1) {
                  return '<a href="javascript:void(0)" class="badge badge-success edit-status">Aktif</a>';
                } else {
                  return '<a href="javascript:void(0)" class="badge badge-danger edit-status">Nonaktif</a>';
                }
              }
            },
            {class: 'text-center', data: 'total_klik', title: 'Total Klik'},
            {class: 'text-center', data: 'total_pendapatan', name: 'users.name', title: 'Total Pendapatan'},
            {
              class: 'text-center', data: 'id_user', title: 'Aksi', searchable: false, orderable: false,
              render: function (data, type, row, meta) {
                return '<button class="btn btn-primary btn-sm btn-danger delete-action"><i class="fa fa-trash-o"></i></button>';
              }
            }
          ],
          ajax: {
            url: process.env.BASE_URL + "/auth/blogger",
            global: false,
            headers: {
              Authorization: this.$auth.getToken("local")
            }
          }
        }
      }
    },
    methods: {
      async editAction(id) {
        this.action_modal = 'Ubah Campaign Banner';
        await this.$axios.$put('/auth/change-status/' + id)
          .then(response => {
            if (response.status) {
              $("#" + this.datatable.instance + "").DataTable().ajax.reload(null, false);
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
              this.$axios.$delete('/auth/blogger/' + id)
                .then(response => {
                  if (response.status) {
                    swal("Sukses", "Blogger berhasil dihapus!", "success");
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

      $("tbody", this.$refs[self.datatable.instance]).on("click", ".edit-status", function () {
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
