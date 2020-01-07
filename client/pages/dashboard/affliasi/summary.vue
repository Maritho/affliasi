<template>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"> Blogger</h1>
        </div>
      </div>
    </div>
    <div class="content">
      <div class="card">
        <div class="card-body shadow">
          <div class="row">
            <div class="col-lg-6">
              <div class="row">
                <div class="col-lg-3">
                  <i class="fa fa-user-circle-o" style="font-size: 70px"></i>
                </div>
                <div class="col-lg-9">
                  <button class="btn btn-primary btn-sm pull-right" @click="show_modal_penarikan = true">Ajukan
                    Penarikan
                  </button>
                  <div class="font-weight-bold">{{this.$store.state.auth.user.name}}</div>
                  <div class="font-weight-bold"><a :href="this.$store.state.auth.user.url_blog">{{this.$store.state.auth.user.url_blog}}</a>
                  </div>
                  <div class="font-weight-bold">Total Pendapatan</div>
                  <div class="font-weight-bold">Rp. {{this.$auth.state.user.pendapatan}}</div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <button class="btn btn-primary btn-sm pull-right" @click="show_modal_ubah = true">Ganti Rekening
              </button>
              <div class="font-weight-bold">Rekening</div>
              <div class="font-weight-bold">Atas Nama : {{this.$store.$auth.state.user.bank ? this.$store.$auth.state.user.bank.bank_name : ''}}</div>
              <div class="font-weight-bold">Nomor : {{this.$store.$auth.state.user.bank ? this.$store.$auth.state.user.bank.bank_rekening : ''}}</div>
              <div class="font-weight-bold">Bank : {{this.$store.$auth.state.user.bank ? this.$store.$auth.state.user.bank.bank: ''}}</div>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-body shadow">
          <div class="row">
            <div class="col-lg-6">
              <h4 class="mb-3 text-dark">Banner Aktif</h4>
              <div class="card">
                <div class="card-body shawdow">
                  <div class="affiliate-moladin" data-affliate-id="1" data-width="200" data-style="img-fluid"
                       data-height="100"></div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <h4 class="mb-3 text-dark">Embed Kode</h4>
              <div class="card">
                <div class="card-body shawdow">
                  <div class="form-group">
                    <textarea rows="5" id="codeSample" readonly v-model="code" class="form-control"></textarea>
                  </div>
                  <div class="form-group">
                    <button class="btn btn-primary btn-sm pull-right" @click="copyText">Salin Kode</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-body shadow">
          <h4 class="mb-3 text-dark">Daftar Transaksi</h4>
          <Datatables :instance="datatable.instance" :columns="datatable.columns" :order="1" :ajax="datatable.ajax"
                      :footer="true"></Datatables>
        </div>
      </div>

      <Modal :isSmall="true" title="Permintaan Penarikan" v-if="show_modal_penarikan"
             @close="show_modal_penarikan = false">
        <form @submit.prevent="validateBeforeSubmitPenarikan">
          <div class="modal-body">
            <div class="form-group">
              <label>Jumlah</label>
              <input type="number" class="form-control" v-model="penarikan.jumlah"
                     placeholder="Jumlah Yang Akan Ditarik">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="show_modal_penarikan = false">Batal</button>
            <button type="submit" class="btn btn-primary">Kirim Permintaan</button>
          </div>
        </form>
      </Modal>

      <Modal title="Ubah Rekening" v-if="show_modal_ubah" @close="show_modal_ubah = false">
        <form @submit.prevent="validateBeforeSubmitRekening">
          <div class="modal-body">
            <div class="form-group">
              <label>Nama Rekening</label>
              <input type="text" class="form-control" v-model="rekenig.rekening_name"
                     placeholder="Nama Rekening Anda">
            </div>
            <div class="form-group">
              <label>Nomor Rekening</label>
              <input type="text" class="form-control" v-model="rekenig.rekening_number"
                     placeholder="Nomor Rekening Anda">
            </div>
            <div class="form-group">
              <label>Bank</label>
              <input type="text" class="form-control" v-model="rekenig.rekening_bank"
                     placeholder="Bank Rekening Anda">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="show_modal_ubah = false">Batal</button>
            <button type="submit" class="btn btn-primary">Ubah</button>
          </div>
        </form>
      </Modal>

    </div>
  </div>
</template>
<script>

  import Datatables from "../../../components/DataTable";
  import Modal from "../../../components/Modal";

  export default {
    head: {
      script: [
        {src: '/client.js'}
      ]
    },
    components: {
      Datatables,
      Modal
    },
    data() {
      return {
        rekenig: {
          rekening_name: this.$store.$auth.state.user.bank ? this.$store.$auth.state.user.bank.bank_name : '',
          rekening_number: this.$store.$auth.state.user.bank ? this.$store.$auth.state.user.bank.bank_rekening : null,
          rekening_bank: this.$store.$auth.state.user.bank ? this.$store.$auth.state.user.bank.bank : ''
        },
        penarikan: {
          jumlah: 0
        },
        show_modal_ubah: false,
        show_modal_penarikan: false,
        code: '// tempelkan di atas </body> \r <script charset="utf-8" src="https://localhost:3000/client.js"/> \r\r // tempelkan di mana anda akan menempatkan banner \r <div class="affiliate-moladin" data-affliate-id="' + this.$auth.state.user.id_user + '" data-width="200" data-style="img-fluid" data-height="100"></div>',
        datatable: {
          instance: 'tableData',
          columns: [
            {class: 'text-center', orderable: false, searchable: false, data: 'id_transaction', title: 'No.'},
            {class: 'text-center', data: 'ip', title: 'Pengguna'},
            {class: 'text-center', data: 'created_at', title: 'Tanggal'},
            {class: 'text-center', data: 'total_belanja', title: 'Total Belanja'},
            {class: 'text-center', data: 'komisi', title: 'Komisi'},
            {class: 'text-center', data: 'cookie', title: 'Cookies'}
          ],
          ajax: {
            url: process.env.BASE_URL + "/transaction/all",
            global: false,
            headers: {
              Authorization: this.$auth.getToken("local")
            }
          }
        }
      }
    },
    methods: {
      async validateBeforeSubmitRekening() {
        await this.$axios.$put('/auth/rekening', this.rekenig)
          .then(response => {
            if (response.status) {
              this.$auth.fetchUser()
              this.$swal('Sukses', 'Rekening berhasil diubah', 'success')
              this.show_modal_ubah = false;
            } else {
              this.$swal('Opss', response.message, 'error')
            }
          })
      },
      async validateBeforeSubmitPenarikan() {
        await this.$axios.$post('/penarikan', this.penarikan)
          .then(response => {
            if (response.status) {
              this.$swal('Sukses', 'Permintaan penarikan berhasil dikirim', 'success')
              this.show_modal_penarikan = false;
              this.$auth.fetchUser()
            } else {
              this.$swal('Opss', response.message, 'error')
            }
          })
      },
      copyText() {
        let copyText = document.getElementById('codeSample');
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
        this.$swal('Sukses', 'Kode berhasil disalin', 'success')
      }
    },
    mounted() {
      const self = this;
      const dataTable = $("#" + self.datatable.instance + "").DataTable(this.parameters);

      $("#" + self.datatable.instance + "" + ' tfoot th').each(function () {
        let title = $(this).text();
        let elem = '';

        if (title == 'No.' || title == 'Action') {
          elem = '';
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
