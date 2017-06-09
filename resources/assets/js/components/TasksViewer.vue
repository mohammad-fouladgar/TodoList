
<template>
  <div class="dv">
    <div class="dv-header">
      <div class="dv-header-title">
        <strong>{{title}}</strong>
      </div>
      <div class="dv-header-columns">
        <span class="dv-header-pre">Status: </span>
        <select class="dv-header-select" v-model="query.search_status" v-on:change="onChange">
          <option v-for="status in statuses" :value="status">{{status}}</option>
        </select>
      </div>
    </div>
    <div class="dv-body">
      <table class="dv-table">
        <thead>
          <tr>
            <th v-for="column in columns" @click="toggleOrder(column)">
              <span>{{column}}</span>
              <span class="dv-table-column" v-if="column === query.column">
                <span v-if="query.direction === 'desc'">&darr;</span>
                <span v-else>&uarr;</span>
              </span>
            </th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr  v-for="(row , index) in model.tasks">
            <td v-for="(value, key) in row">

            <span :class="classStatusObject(key,value)">{{ value }}</span>
           
            </td>
            <td>
            <select class="select" v-on:change="updateStatus(row)" v-model="row.status">
              <option value="done">done</option>
              <option value="cancelled">cancelled</option>
            </select>
            <button class="btn btn-danger" @click="deleteTask(row,index)" >
              <span class="glyphicon glyphicon-remove"></span> Delete 
            </button>

            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

</template>
<script>
  export default {
    props: ['source', 'title'],
    data() {
      return {
        model: {},
        columns: {},
        statuses: {},
        query: {
          column: 'id',
          direction: 'desc',
          search_status: 'all'
        },
      }
    },
    created() {
      this.fetchIndexData()
    },

    
    methods: {

      classStatusObject(key,value){
        return {
          'label label-default' : key   == 'status' && value == 'cancelled',
          'label label-success' : key   == 'status' && value == 'done',
          'label label-primary' : key   == 'status' && value == 'new',
          'label label-danger'  : key   == 'status' && value == 'failed',
          'label label-warning' : key   == 'status' && value == 'extended',
        }
      },
      updateStatus(task)
      {
        var vm = this;
        axios.patch('/todolists/'+this.model.id+'/task/'+task.id,{status : task.status})
          .then(function(response) {
            console.log(response.data);
          })
          .catch(function(response) {
            console.log(response)
          })
      },

      deleteTask(task,index)
      {
        var vm = this;
        
        axios.delete('/todolists/'+this.model.id+'/task/'+task.id)
          .then(function(response) {
            // console.log(tasks);
           vm.$delete(vm.model.tasks,index);
          })
          .catch(function(response) {
            console.log(response)
          })
      },
      toggleOrder(column) {
        if(column === this.query.column) {
          // only change direction
          if(this.query.direction === 'desc') {
            this.query.direction = 'asc'
          } else {
            this.query.direction = 'desc'
          }
        } else {
          this.query.column = column
          this.query.direction = 'asc'
        }
        this.fetchIndexData()
      },
      onChange(){
        var vm = this;
          axios.get(`${this.source}?column=${this.query.column}&direction=${this.query.direction}&status=${this.query.search_status}`)
          .then(function(response) {
            Vue.set(vm.$data, 'model', response.data.model)
          })
          .catch(function(response) {
            console.log(response)
          })
      },
      fetchIndexData() {
        var vm = this
        axios.get(`${this.source}?column=${this.query.column}&direction=${this.query.direction}&status=${this.query.search_status}`)
          .then(function(response) {
            // console.log(response.data.model);
            Vue.set(vm.$data, 'model', response.data.model)
            Vue.set(vm.$data, 'columns', response.data.columns)
            Vue.set(vm.$data, 'statuses', response.data.statuses)
          })
          .catch(function(response) {
            console.log(response)
          })
      }
    }
  }
</script>
