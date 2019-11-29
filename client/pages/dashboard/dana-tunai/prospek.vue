<template>
  <div class="content-wrapper" style="min-height: 700px;">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">DANA TUNAI</h1>
            <span>Semua Data Dana Tunai</span>
          </div>
        </div>
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-body">
            <Datatables :columns="columns" :ajax="ajax"></Datatables>
          </div>
        </div>
      </div>
    </div>

    <Modal title="Change Data" v-if="show_modal" @close="show_modal = false">
      <form @submit.prevent="validateBeforeSubmit">
        <div class="modal-body">
          <div class="form-group">
            <label>Status</label>
            <select class="form-control" v-model="form.status" name="status" v-validate="'required'" :class="{ 'is-invalid': errors.first('status') }">
              <option value="">Pilih Status</option>
              <option value="approve">Approve</option>
              <option value="reject">Reject</option>
              <option value="pencairan">Pencairan</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="show_modal = false">Batal</button>
          <button type="submit" class="btn btn-primary">Ubah Status</button>
        </div>
      </form>
    </Modal>
  </div>
</template>

<script>
import Datatables from "../../../components/DataTable";
import Modal from "../../../components/Modal";

export default {
  middleware: ["auth"],
  layout: "default",
  components: {
    Datatables,
    Modal
  },
  data() {
    return {
      show_modal: true,
      form: {

      },
      columns: [
        { class: 'text-center', orderable: false, searchable: false, data: 'id', title: 'No.'},
        { class: 'text-center', data: 'id', title: 'ID'},
        { class: 'text-center', data: 'created_at', title: 'Tgl Masuk'},
        { class: 'text-center', data: 'customer_name', title: 'Konsumen'},
        { class: 'text-center', data: 'customer_address', title: 'Alamat', 
            render: function(data, type, row, meta) {
                return data;
            }
        },
        { class: 'text-center', data: 'customer_domicile', title: 'Domisili', 
            render: function(data, type, row, meta) {
                return row.customer_region_name +'\r'+ row.customer_district_name
            }
        },
        { class: 'text-center', data: 'vehicle_model', title: 'Jenis Motor'},
        { class: 'text-center', data: 'vehicle_manufacture_year', title: 'Tahun'},
        { class: 'text-center', data: 'company_name', title: 'Leasing'},
        { class: 'text-center', data: 'loan_amount', title: 'Dana Diajukan',
            render: function(data, type, row, meta) {
                return 'Rp. ' + data
            }
        },
        { class: 'text-center', data: 'loan_installment_duration', title: 'Tenor & Cicilan',
            render: function(data, type, row, meta) {
                return 'Rp. ' + row.loan_installment_amount +' x '+ data +' Bulan'
            }
        },
        {
            class: 'text-center', data: 'id', title: 'Status', isFilter: false,
            render: function (data, type, row, meta) {
                if (row.is_prospect == 1) {
                    return '<a href="javascript:void(0)" class="badge badge-primary text-white edit-action-prospek">Pending</a>';   
                } else {
                    switch (row.status) {
                        case '1':
                            return '<a href="javascript:void(0)" class="badge badge-warning edit-action">Approve</a>';      
                            break;
                        case '2':
                            return '<a href="javascript:void(0)" class="badge badge-danger edit-action">Reject</a>';      
                            break;
                        case '3':
                            return '<a href="javascript:void(0)" class="badge badge-success edit-action">Pencairan</a>';      
                            break;
                        default:
                            return '<a href="javascript:void(0)" class="badge badge-info edit-action">Prosess</a>';
                            break;
                    }
                }
            }
        }
      ],
      ajax: {
        url: process.env.BASE_URL + "/loan/crm?type=pooling",
        global: false,
        headers: {
          Authorization: this.$auth.getToken("local")
        }
      }
    };
  },

  methods: {
    async validateBeforeSubmit() {
      this.$validator.validate().then(valid => {
        if (valid) {
            
            this.$nuxt.$loading.loading = true;

          }
      });
    },

    async editProperty(id) {
      this.show_modal = true;
    }
  },
  mounted() {
    
    const dataTable = $("#tableData").DataTable(this.parameters);

    const self = this;
    $("tbody", this.$refs.table).on("click", ".edit-action", function() {
      const cell = dataTable.cell($(this).closest("td"));
      self.editProperty(cell.data());
    });
  }
};
</script>
