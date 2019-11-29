<template>
  <div class="table-responsive">
    <table id="tableData" ref="table" class="table table-bordered table-hover">
      <thead>
      <tr>
        <th
          v-for="(column, i) in parameters.columns"
          v-html="column"
          class="text-center"
          :key="i"
        ></th>
      </tr>
      </thead>
      <tfoot v-if="footer">
      <tr>
        <th v-for="(column, i) in parameters.columns" v-html="column.title" :key="i"></th>
      </tr>
      </tfoot>
    </table>
  </div>
</template>

<script>
    export default {
        data() {
            return {
                dataTable: {}
            };
        },
        methods: {
            title(column) {
                return column.title || this.titleCase(column.data);
            },
            titleCase(str) {
                return str.replace(/\w\S*/g, function (txt) {
                    return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                });
            }
        },
        computed: {
            parameters() {
                const vm = this;
                return $.extend(
                    {
                        fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                            var index = iDisplayIndex + 1;
                            $('td:eq(0)', nRow).html(index);
                            return nRow;
                        },
                        serverSide: true,
                        processing: true,
                        order: [[this.order, 'desc']]
                    },
                    {
                        ajax: this.ajax,
                        columns: this.columns,
                    },
                    this.options
                );
            }
        },
        props: {
            order: {default: 0},
            footer: {default: false},
            columns: {type: Array},
            ajax: {default: ""},
            options: {}
        },
        mounted() {
            const dataTable = $("#tableData").DataTable(this.parameters);
        },
        destroyed() {
            // this.dataTable.destroy();
        }
    };
</script>
