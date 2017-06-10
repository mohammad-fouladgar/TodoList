
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
            <th>update Due date</th>
          </tr>
        </thead>
        <tbody>
          <tr  v-for="(row , index) in model.tasks">
            <td v-for="(value, key) in row">

            <span :class="classStatusObject(key,value)">{{ value }}</span>
           
            </td>
            <td>


            <select class="select form-control" v-on:change="updateStatus(row,$event)" name='sts'>
              <option value="done">done</option>
              <option value="cancelled">cancelled</option>
            </select>
            <span class="btn btn-danger" @click="deleteTask(row,index)" >
              <span class="glyphicon glyphicon-remove"></span> Delete 
            </span>

            </td>
            <td>
              
              <select class="select form-control" v-on:change="updateDue(row,$event)" >
              <option value="1">1 Days</option>
              <option value="2">2 Days</option>
              <option value="3">3 Days</option>
              <option value="4">4 Days</option>
              <option value="5">5 Days</option>
              <option value="6">6 Days</option>
              <option value="7">7 Days</option>
            </select>
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
          'text-danger'  : key   == 'status'   && value == 'failed',
          'label label-warning' : key   == 'status'   && value == 'extended',
          'label label-danger'  : key   == 'due_date' && ! Date.parse(value),
        }
      },
      updateStatus(task,event)
      {
        var newStatus = event.target.value;
        
        var vm = this;
        axios.patch('/todolists/'+this.model.id+'/task/'+task.id,{status : newStatus})
          .then(function(response) {
            task.status = newStatus;
            console.log(response.data);
          })
          .catch(function(response) {
            console.log(response)
          })
      },

      updateDue(task,event){
        var vm = this;
        var due = event.target.value;

        $.ajax({
          url : '/task/'+task.id+'/due/'+due,
          type:'get',
          success :function(response){
            task.status = response.status;
            task.due_date = response.due_date;
            // console.log(task);
          }
        });
       
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
