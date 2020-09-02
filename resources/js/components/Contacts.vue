<template>
    <div>
      <h1>Add Contacts</h1>
      <form method="POST" action="#" @submit.prevent="edit ? updateContact(contact.id) : createContact()" enctype="multipart/form-data">
          <div class="form-group">
              <label >Name</label>
              <input v-model="contact.name" type="text" name="name" class="form-control">
          </div>

          <div class="form-group">
              <label >Email</label>
              <input v-model="contact.email" type="text" name="email" class="form-control">
          </div>

          <div class="form-group">
              <label >Telephone/Cellphone Number</label>
              <input v-model="contact.phone" type="text" name="phone" class="form-control">
          </div>

          <div class="form-group">
                   <label>Image</label>
                  <input v-on:change="imageSelected" type="file" accept="image/*" name="image"  class="form-control ">
          </div>

          <div v-if="contact.image" class="form-group mt-3" >
                  <img :src="contact.image" class="figure-img img-fluid rounded" style="max-height:100px;">
          </div>

          <div class="form-group">
              <button v-show="!edit" type="submit" class="btn btn-primary">New Contact</button>
              <button v-show="edit" type="submit" class="btn btn-primary">Update Contact</button>
          </div>
          
      </form>

      <h1>Contacts</h1>
      <table class="table table-striped">
          <thead class="thead-dark center">
              <th>Name</th>
              <th>Email</th>
              <th>Phone number</th>
              <th>Image</th>
              <th>Action</th>
          </thead>
          <tbody>
              <tr  v-for="contact in list" :key="contact.id" >
                  <td>{{contact.name}}</td>
                  <td>{{contact.email}}</td>
                  <td>{{contact.phone}}</td>
                  <td><img :src="contact.image" alt="" style="width: 50px; height: 50px;"></td>  
                  <td><button @click="showContact(contact.id)" class="btn btn-success btn-xs">Edit</button>
                      <button @click="deleteContact(contact.id)" class="btn btn-danger btn-xs">Delete</button></td>
                 
                  
              </tr>
          </tbody>

      </table>
    </div>
</template>


<script>
export default {
    data: function(){
        return {
            edit: false,
            list: [],
            contact: {
                id:'',
                email:'',
                phone:'',
                image: ''
            }
        }
    },
    mounted: function(){
        console.log('Contacts Component loaded');
        this.fetchContactList();
    },
    methods: {
        fetchContactList: function(){
            console.log('fecthing contacts');
            axios.get('api/contacts')
            .then((response) => {
               
                this.list = response.data;
            })
            .catch((error) => {
                return error;
            });
        },
        imageSelected: function(e){
            let self = this;
            
            self.contact.image = e.target.files[0];
            
            let reader = new FileReader();
            
            reader.onloadend = e => {
                self.contact.image = e.target.result;
                
            };
            reader.readAsDataURL(self.contact.image);
        },
        createContact: function(){
            
            let self = this;
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Your work has been saved',
                showConfirmButton: false,
                timer: 2500
            })
            let params = Object.assign({}, self.contact)
            console.log(params)
            axios.post('api/contact/store' , params)
            .then(function(){
                 self.contact.name = '';
                self.contact.email = '';
                self.contact.phone = '';
                self.contact.image = '';

                self.edit = false;
                self.fetchContactList();
            })
            .catch(function(error){
                console.log(error)
            });
           
        },
        showContact: function(id){
            let self = this;
           
            axios.get(`api/contact/${id}`)
            .then(function(response){
                console.log(response.data)
                self.contact.id = response.data.id;
                self.contact.name = response.data.name;
                self.contact.email = response.data.email;
                self.contact.phone = response.data.phone;
                self.contact.image = response.data.image;
                
                
            })
            
            .catch(function(error){
                console.log(error)
            });
            
            self.edit = true;
        },
        updateContact: function(id){
            let self = this;
             Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Successfully updated',
                showConfirmButton: false,
                timer: 2500
            })
            let params = Object.assign({}, self.contact)
            axios.patch(`api/contact/${id}`, params)
            .then(function(){
                self.contact.name = '';
                self.contact.email = '';
                self.contact.phone = '';
                self.contact.image = '';
                self.edit = false;
                self.fetchContactList();
            })
            .catch(function(error){
                console.log(error)
            });
        },
        deleteContact: function(id){
            let self = this;
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Data Deleted ',
                showConfirmButton: false,
                timer: 2500
            })
            axios.delete(`api/contact/${id}`)
            .then(function(response){
               self.fetchContactList();
            })
            .catch(function(error){
                console.log(error)
            })
        }

    }
}
</script>