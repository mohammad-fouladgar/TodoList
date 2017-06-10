
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
          <tr v-for="(row , index) in model">
            <td v-for="(value, key) in row">

            <span :class="classStatusObject(key,value)">{{ value }}</span>
           
            </td>
            <td>
            <button type="button" class="btn btn-warning" @click='tasks(row.id)'>
            <span class="glyphicon glyphicon-eye-open"></span> Tasks
            </button>

            <button type="button" class="btn" @click='cancelTask(row)'>
            <span class="glyphicon glyphicon-ban-circle"></span> Cancel
            </button>
            <button class="btn btn-danger" @click='deleteTodo(row,index)'>
              <span class="glyphicon glyphicon-remove" ></span> Delete
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

          'label label-default' : key   == 'status'   && value == 'cancelled',
          'label label-success' : key   == 'status'   && value == 'done',
          'label label-primary' : key   == 'status'   && value == 'new',
          'label label-danger'  : key   == 'status'   && value == 'failed',
        }
      },
      tasks(id){
        window.location = '/todolists/'+id
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
        console.log(this.query.search_status);
        var vm = this;
          axios.get(`${this.source}?column=${this.query.column}&direction=${this.query.direction}&status=${this.query.search_status}`)
          .then(function(response) {
            Vue.set(vm.$data, 'model', response.data.model)
          })
          .catch(function(response) {
            console.log(response)
          })
      },
      deleteTodo(todo,index){
        var vm = this;

        axios.delete('/todolists/'+todo.id)
          .then(function(response) {
            console.log(response);
           vm.$delete(vm.model,index);

          })
          .catch(function(response) {
            if (response.response) {
              alert(response.response.data.errorMessage);
              console.log(response.response.data.errorMessage);
            }else if (response.request) {
              console.log(response.request);
            } else {
              // Something happened in setting up the request that triggered an Error
              console.log('Error', response.message);
            }
          })
      },
      cancelTask(task){
        var vm = this;

        axios.patch('/todolists/'+task.id+'/cancel/')
          .then(function(response) {
            task.status = 'cancelled';
            console.log(response.data);
          })
          .catch(function(response) {
            console.log(response)
          })
      },
      fetchIndexData() {
        var vm = this
        axios.get(`${this.source}?column=${this.query.column}&direction=${this.query.direction}&status=${this.query.search_status}`)
          .then(function(response) {
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
