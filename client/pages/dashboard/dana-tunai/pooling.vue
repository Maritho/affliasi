<template>
  <div class="content-wrapper" style="min-height: 700px;">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ this.$store.state.auth.user.role.name }}</h1>
            <span>Semua Data {{ this.$store.state.auth.user.role.name }}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-body">
            <Datatables :columns="columns" :order="1" :ajax="ajax" :footer="true"></Datatables>
          </div>
        </div>
      </div>
    </div>

    <Modal title="Change Status" v-if="show_modal" @close="show_modal = false">
      <form @submit.prevent="validateBeforeSubmit">
        <div class="modal-body">
          <div class="form-group">
            <label>Status</label>
            <select class="form-control" @change="handleChangeSelect" v-model="form.status" name="status"
                    v-validate="'required'" :class="{ 'is-invalid': errors.first('status') }">
              <option value="">Pilih Status</option>
              <option value="cancel">Cancel</option>
              <option value="approve">Approve</option>
              <option value="reject">Reject</option>
              <option value="pencairan">Pencairan</option>
            </select>
          </div>
          <template v-if="form.status == 'cancel'">
            <div className="form-group">
              <label>Catatan</label>
              <textarea type="text" name="note_cancel" v-model="form.note_cancel" class="form-control"
                     placeholder="Catatan"/>
            </div>
          </template>
          <template v-if="form.status == 'approve'">
            <div className="form-group">
              <label>Catatan</label>
              <textarea type="text" name="note_approve" v-model="form.note_approve" class="form-control"
                     placeholder="Catatan"/>
            </div>
          </template>
          <template v-if="form.status == 'reject'">
            <div className="form-group">
              <label>Catatan</label>
              <textarea type="text" name="note_reject" v-model="form.note_reject" class="form-control"
                     placeholder="Catatan"/>
            </div>
          </template>
          <template v-if="form.status == 'pencairan'">
            <div className="form-group">
              <label>Plafon/OTR</label>
              <input type="number" name="final_loan_amount" v-model="form.final_loan_amount" class="form-control"
                     placeholder="Plafon/OTR"/>
            </div>
            <div className="form-group">
              <label>Tenor</label>
              <input type="number" name="final_loan_duration" v-model="form.final_loan_duration" class="form-control"
                     placeholder="Tenor"/>
            </div>
            <div className="form-group">
              <label>Cicilan</label>
              <input type="number" name="final_loan_installment" v-model="form.final_loan_installment"
                     class="form-control" placeholder="Cicilan"/>
            </div>
            <div className="form-group">
              <label>Waktu Pencairan</label>
              <input type="date" name="final_melting_date" v-model="form.final_melting_date" class="form-control"
                     placeholder="Waktu Pencairan"/>
            </div>
          </template>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="show_modal = false">Batal</button>
          <button type="submit" class="btn btn-primary">Ubah Status</button>
        </div>
      </form>
    </Modal>

    <Modal title="Change Data" v-if="show_modal_data" @close="show_modal_data = false">
      <form @submit.prevent="validateBeforeSubmitData">
        <div class="modal-body">
          <div class="form-group">
            <label>Konsumen</label>
            <input type="text" class="form-control" v-model="data.customer_name" placeholder="Konsumen">
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <textarea type="text" class="form-control" v-model="data.customer_address" placeholder="Alamat"/>
          </div>
          <div class="form-group">
            <label>Status</label>
            <select class="form-control" v-model="data.customer_province_id" name="customer_province_id">
              <option value="">Pilih Provinsi</option>
              <option v-for="(provinsi, index) in this.$store.state.provincies" :key="index" :value="provinsi.id">
                {{provinsi.name}}
              </option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="show_modal_data = false">Batal</button>
          <button type="submit" class="btn btn-primary">Ubah Status</button>
        </div>
      </form>
    </Modal>
  </div>
</template>

<script>
    import Datatables from "../../../components/DataTable";
    import Modal from "../../../components/Modal";
    import {priceDecimal} from '../../../helper/app';

    export default {
        middleware: ["auth"],
        layout: "default",
        components: {
            Datatables,
            Modal
        },
        data() {
            return {
                show_modal: false,
                show_modal_data: false,
                data: {
                    customer_title: null,
                    customer_name: null,
                    customer_phone: null,
                    customer_email: null,
                    customer_address: null,
                    customer_province_id: null,
                    customer_region_id: null,
                    customer_district_id: null,
                    customer_postal_code: null,
                    customer_domicile: null,
                    vehicle_type: null,
                    vehicle_brand_id: null,
                    vehicle_model: null,
                    vehicle_manufacture_year: null,
                    vehicle_license_plate: null,
                    tnkb_own: null,
                    tnkb_domicile: null,
                    tnkb_someone_else: null,
                    tnkb_outside_domicile: null,
                    financing_company_id: null,
                    loan_pricelist_id: null,
                    loan_duration: null,
                    loan_amount: null,
                    husband_ktp_file: null,
                    wife_ktp_file: null,
                    referral_code: null
                },
                form: {
                    loan_id: null,
                    approved_loan_amount: null,
                    approved_loan_duration: null,
                    approved_contract_number: null,
                    status_reason: null,
                    final_loan_amount: null,
                    final_loan_duration: null,
                    final_loan_installment: null,
                    final_melting_date: null,
                    status: 'approve',
                    note_approve: null,
                    note_cancel: null,
                    note_reject: null,
                },
                columns: [
                    {class: 'text-center', orderable: false, searchable: false, data: 'id', title: 'No.'},
                    {class: 'text-center', data: 'id', title: 'ID'},
                    {class: 'text-center', data: 'created_at', title: 'Tgl Masuk'},
                    {class: 'text-center', data: 'customer_name', title: 'Konsumen'},
                    {
                        class: 'text-center', data: 'customer_address', title: 'Alamat',
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        class: 'text-center', data: 'customer_domicile', title: 'Domisili',
                        render: function (data, type, row, meta) {
                            return row.customer_region_name + '\r' + row.customer_district_name
                        }
                    },
                    {class: 'text-center', data: 'vehicle_model', title: 'Jenis Motor'},
                    {class: 'text-center', data: 'vehicle_manufacture_year', title: 'Tahun'},
                    {class: 'text-center', data: 'company_name', title: 'Leasing'},
                    {
                        class: 'text-center', data: 'loan_amount', title: 'Dana Diajukan',
                        render: function (data, type, row, meta) {
                            return 'Rp. ' + priceDecimal(data)
                        }
                    },
                    {
                        class: 'text-center', data: 'loan_installment_duration', title: 'Tenor & Cicilan',
                        render: function (data, type, row, meta) {
                            return 'Rp. ' + priceDecimal(row.loan_installment_amount) + ' x ' + data + ' Bulan'
                        }
                    },
                    {
                        class: 'text-center', data: 'status', title: 'Status',
                        render: function (data, type, row, meta) {
                            if (row.is_prospect == 1) {
                                return '<span class="badge badge-primary text-white">Pending</span>';
                            } else {
                                switch (row.status) {
                                    case '1':
                                        return '<span class="badge badge-warning">Approve</span>';
                                        break;
                                    case '2':
                                        return '<span class="badge badge-secondary">Reject</span>';
                                        break;
                                    case '3':
                                        return '<span class="badge badge-success">Pencairan</span>';
                                        break;
                                    case '4':
                                        return '<span class="badge badge-danger">Cancel</span>';
                                        break;
                                    default:
                                        return '<span class="badge badge-info">Prosess</span>';
                                        break;
                                }
                            }
                        }
                    },
                    {
                        class: 'text-center', data: 'id', title: 'Action', orderable: false, searchable: false,
                        render: function (data, type, row, meta) {
                            return '<div class="action-td dropdown other-menu blue show">' +
                                '<a href="javascript:void(0)" class="dropdown-toggle toggleAction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                                '<span class="dot"></span>' +
                                '</a>' +
                                '<div class="dropdown-menu">' +
                                '<a href="javascript:void(0)" class="dropdown-item edit-action">Ubah Status</a>' +
                                // '<a href="javascript:void(0)" class="dropdown-item edit-action-data">Ubah Data</a>' +
                                '</div>' +
                                '</div>';
                        }
                    },
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
                        const self = this;
                        let status = self.form.status;
                        let loan_id = self.form.loan_id;

                        let data = null;

                        switch (status) {

                            case 'cancel':
                                data = {
                                    note_cancel: this.form.note_cancel
                                }
                                break;
                            case 'approve':
                                data = {
                                    approved_loan_amount: this.form.approved_loan_amount,
                                    approved_loan_duration: this.form.approved_loan_duration,
                                    approved_contract_number: this.form.approved_contract_number,
                                    note_approve: this.form.note_approve
                                }
                                break;
                            case 'reject':
                                data = {
                                    status_reason: this.form.status_reason,
                                    note_reject: this.form.note_reject
                                }
                                break;
                            case 'pencairan':
                                data = {
                                    final_loan_amount: this.form.final_loan_amount,
                                    final_loan_duration: this.form.final_loan_duration,
                                    final_loan_installment: this.form.final_loan_installment,
                                    final_melting_date: this.form.final_melting_date
                                }
                                break;
                        }

                        if (this.form.loan_id !== null || this.form.status !== '') {
                            self.$axios.$put(process.env.BASE_URL + '/loan/crm/' + status + '/' + loan_id, data)
                                .then(response => {
                                    if (response.success) {
                                        this.$swal('Sukses', 'Status berhasil diubah', 'success');
                                        this.show_modal = false;
                                        $('#tableData').DataTable().ajax.reload(null, false);

                                    } else {
                                        this.$swal('Opps', response.data, 'error');
                                    }
                                })
                                .catch(error => {
                                    this.$swal('Opps', 'sepertinya ada yang salah', 'error');
                                    throw(error);
                                });
                        } else {
                            this.$swal('Opps', 'sepertinya ada yang salah', 'error');
                        }

                    }
                });
            },

            async handleChangeSelect(e) {
                const self = this;
                const value = e.target.value;
                await this.$axios.$get(process.env.BASE_URL + '/loan/crm/' + self.form.loan_id + '/detail')
                    .then(response => {
                        if (response.success) {

                            let approved_loan_amount = response.data.approved_loan_amount;
                            let approved_loan_duration = response.data.approved_loan_duration;

                            if (approved_loan_amount == null || approved_loan_amount == '') {
                                approved_loan_amount = response.data.loan_amount;
                            }

                            if (approved_loan_duration == null || approved_loan_duration == '') {
                                approved_loan_duration = response.data.loan_installment_duration;
                            }

                            switch (value) {
                                case "approve":
                                    self.form = {
                                        loan_id: response.data.id,
                                        approved_loan_amount: response.data.approved_loan_amount,
                                        approved_loan_duration: response.data.approved_loan_duration,
                                        approved_contract_number: response.data.approved_contract_number,
                                        status_reason: response.data.status_reason,
                                        final_loan_amount: response.data.final_loan_amount,
                                        final_loan_duration: response.data.final_loan_duration,
                                        final_loan_installment: response.data.final_loan_installment,
                                        final_melting_date: response.data.final_melting_date,
                                        status: value,
                                        note_approve: response.data.note_approve,
                                        note_cancel: response.data.note_cancel,
                                        note_reject: response.data.note_reject,
                                    }
                                    break;

                                case "reject":
                                    self.form = {
                                        loan_id: response.data.id,
                                        approved_loan_amount: response.data.approved_loan_amount,
                                        approved_loan_duration: response.data.approved_loan_duration,
                                        approved_contract_number: response.data.approved_contract_number,
                                        status_reason: response.data.status_reason,
                                        final_loan_amount: response.data.final_loan_amount,
                                        final_loan_duration: response.data.final_loan_duration,
                                        final_loan_installment: response.data.final_loan_installment,
                                        final_melting_date: response.data.final_melting_date,
                                        status: value,
                                        note_approve: response.data.note_approve,
                                        note_cancel: response.data.note_cancel,
                                        note_reject: response.data.note_reject,
                                    }
                                    break;

                                case "pencairan":
                                    self.form = {
                                        loan_id: response.data.id,
                                        approved_loan_amount: response.data.approved_loan_amount,
                                        approved_loan_duration: response.data.approved_loan_duration,
                                        approved_contract_number: response.data.approved_contract_number,
                                        status_reason: response.data.status_reason,
                                        final_loan_amount: response.data.approved_loan_amount,
                                        final_loan_duration: response.data.approved_loan_duration,
                                        final_loan_installment: response.data.loan_installment_amount,
                                        final_melting_date: response.data.final_melting_date,
                                        status: value,
                                        note_approve: response.data.note_approve,
                                        note_cancel: response.data.note_cancel,
                                        note_reject: response.data.note_reject,
                                    }
                                    break;
                            }

                        } else {
                            this.$swal('Ops, ada yang salah')
                            return false;
                        }
                    })
                    .catch(error => {
                        throw(error);
                    });
            },

            async editDataProperty(loan_id) {
                await this.$axios.$get(process.env.BASE_URL + '/loan/crm/' + loan_id + '/detail')
                    .then(response => {
                        if (response.success) {

                            let data = {
                                customer_title: response.data.customer_title,
                                customer_name: response.data.customer_name,
                                customer_phone: response.data.customer_phone,
                                customer_email: response.data.customer_email,
                                customer_address: response.data.customer_address,
                                customer_province_id: response.data.customer_province_id,
                                customer_region_id: response.data.customer_region_id,
                                customer_district_id: response.data.customer_district_id,
                                customer_postal_code: response.data.customer_postal_code,
                                customer_domicile: response.data.customer_domicile,
                                vehicle_type: response.data.vehicle_type,
                                vehicle_brand_id: response.data.vehicle_brand_id,
                                vehicle_model: response.data.vehicle_model,
                                vehicle_manufacture_year: response.data.vehicle_manufacture_year,
                                vehicle_license_plate: response.data.vehicle_license_plate,
                                tnkb_own: response.data.tnkb_own,
                                tnkb_domicile: response.data.tnkb_domicile,
                                tnkb_someone_else: response.data.tnkb_someone_else,
                                tnkb_outside_domicile: response.data.tnkb_outside_domicile,
                                financing_company_id: response.data.financing_company_id,
                                loan_pricelist_id: response.data.loan_pricelist_id,
                                loan_duration: response.data.loan_duration,
                                loan_amount: response.data.loan_amount,
                                husband_ktp_file: response.data.husband_ktp_file,
                                wife_ktp_file: response.data.wife_ktp_file,
                                referral_code: response.data.referral_code
                            };

                            this.data = data;
                            this.show_modal_data = true;
                        }

                    })
            },

            async editProperty(loan_id) {
                const self = this;
                await this.$axios.$get(process.env.BASE_URL + '/loan/crm/' + loan_id + '/detail')
                    .then(response => {
                        if (response.success) {
                            let status = '';
                            switch (response.data.status) {
                                case 0:
                                    status = 'process';
                                    break;
                                case 1:
                                    status = 'approve';
                                    break;
                                case 2:
                                    status = 'reject';
                                    break;
                                case 3:
                                    status = 'pencairan';
                                    break;
                                case 4:
                                    status = 'cancel';
                                    break;
                            }

                            let data = {
                                loan_id: response.data.id,
                                approved_loan_amount: response.data.approved_loan_amount,
                                approved_loan_duration: response.data.approved_loan_duration,
                                approved_contract_number: response.data.approved_contract_number,
                                status_reason: response.data.status_reason,
                                final_loan_amount: response.data.final_loan_amount,
                                final_loan_duration: response.data.final_loan_duration,
                                final_loan_installment: response.data.final_loan_installment,
                                final_melting_date: response.data.final_melting_date,
                                status: status,
                                note_approve: response.data.note_approve,
                                note_cancel: response.data.note_cancel,
                                note_reject: response.data.note_reject,
                            }

                            this.form = data;
                            this.show_modal = true;

                        }

                    })
            },

            async getProvince() {
                const self = this;
                await this.$axios.$get(process.env.BASE_URL + '/location/province')
                    .then(response => {
                        if (response) {
                            self.$store.commit('add_provincies', response);
                        }
                    })
            }
        },

        mounted() {

            this.getProvince();

            const dataTable = $("#tableData").DataTable(this.parameters);

            const self = this;
            $("tbody", this.$refs.table).on("click", ".edit-action", function () {
                const cell = dataTable.cell($(this).closest("td"));
                self.editProperty(cell.data());
            });

            $("tbody", this.$refs.table).on("click", ".edit-action-data", function () {
                const cell = dataTable.cell($(this).closest("td"));
                self.editDataProperty(cell.data());
            });

            $('#tableData tfoot th').each(function () {
                let title = $(this).text();
                let elem = '';

                if (title == 'No.' || title == 'Action') {
                    elem = '';
                } else if (title == 'Status') {
                    elem = '<select class="form-control form-control-sm">' +
                        '  <option value="">Pilih Status</option>' +
                        '  <option value="0">Proses</option>' +
                        '  <option value="1">Approve</option>' +
                        '  <option value="2">Reject</option>' +
                        '  <option value="3">Pencairan</option>' +
                        '  <option value="4">Cancel</option>' +
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
    };
</script>
