<template>
  <div class="content-wrapper" style="min-height: 700px">
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"> Blogger</h1>
          </div>
        </div>
      </div>
    </div>
    <div class="content">
      <div class="container">
        <div class="card">
          <div class="card-body shadow">
            <div class="row">
              <div class="col-lg-6">
                <div class="row">
                  <div class="col-lg-3">
                    <i class="fa fa-user-circle-o" style="font-size: 70px"></i>
                  </div>
                  <div class="col-lg-9">
                    <div class="font-weight-bold">{{this.$store.state.auth.user.name}}</div>
                    <div class="font-weight-bold"><a :href="this.$store.state.auth.user.url_blog">{{this.$store.state.auth.user.url_blog}}</a>
                    </div>
                    <div class="font-weight-bold">Total Pendapatan</div>
                    <div class="font-weight-bold">Rp. 10.000.000, 00</div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="font-weight-bold">Rekening :</div>
                <div class="font-weight-bold">Nomor : 1323.32323.3232</div>
                <div class="font-weight-bold">Bank : BCA</div>
                <button class="btn btn-primary btn-sm">Ganti Rekening</button>
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
                    <div class="affiliate-moladin" data-affliate-id="32432434" data-width="200" data-style="img-fluid" data-height="100"></div>
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
          </div>
        </div>

      </div>
    </div>
  </div>
</template>
<script>
  export default {
    head: {
      script: [
        { src: '/client.js' }
      ]
    },
    data() {
      return {
          code: '// tempelkan di atas </body> \r <script charset="utf-8" src="https://localhost:3000/client.js"/> \r\r // tempelkan di mana anda akan menempatkan banner \r <div class="affiliate-moladin" data-affliate-id="32432434" data-width="200" data-style="img-fluid" data-height="100"></div>'
      }
    },
    methods: {
      copyText() {
        let copyText = document.getElementById('codeSample');
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
        this.$swal('Sukses', 'Kode berhasil disalin', 'success')
      }
    },
    mounted() {

    }
  }
</script>
