<template>
  <div class="container">
    <div class="row mt-5">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Users Table</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-success" @click="newModal()">
                Add New
                <i class="fas fa-user-plus fa-fw"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Type</th>
                  <th>Registered At</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in users" :key="user.id">
                  <td>{{ user.id }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.email }}</td>
                  <td>{{ user.type | upText }}</td>
                  <td>{{ user.created_at | myDate }}</td>
                  <td>
                    <a href="#" @click="editModal(user)">
                      <i class="fa fa-edit blue"></i>
                    </a>
                    /
                    <a href="#" @click="deleteUser(user.id)"
                      ><i class="fa fa-trash red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true">

      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-show="!editMode " class="modal-title" id="exampleModalLabel">Add New</h5>
            <h5 v-show="editMode" class="modal-title" id="exampleModalLabel">Edit </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="editMode ? updateUser() : createUser()">
              <div class="form-group">
                <label>Name</label>
                <input
                  v-model="form.name"
                  type="text"
                  name="name"
                  placeholder="Full Name"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('name') }"
                />
                <has-error :form="form" field="name"></has-error>
              </div>

              <div class="form-group">
                <label>Email</label>
                <input v-model="form.email"
                  type="email" name="email" placeholder="Email Address" class="form-control"
                  :class="{ 'is-invalid': form.errors.has('email') }"/>
                <has-error :form="form" field="email"></has-error>
              </div>

              <div class="form-group">
                <label>Type</label>
                <select v-model="form.type" type="text" name="type" placeholder="User Type" 
                  class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                  <option value="">Select User Role</option>
                  <option value="admin">Admin</option>
                  <option value="user">Standard User</option>
                  <option value="author">Author</option>
                </select>
                <has-error :form="form" field="type"></has-error>
              </div>

              <div class="form-group">
                <label>Bio</label>
                <textarea v-model="form.bio"
                  type="text" name="bio"  placeholder="Short bio for the user"
                  class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }">
                </textarea>
                <has-error :form="form" field="bio"></has-error>
              </div>

              <div class="form-group">
                <label>Password</label>
                <input
                  v-model="form.password"
                  type="password"
                  name="password"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('password') }"
                />
                <has-error :form="form" field="password"></has-error>
              </div>

              <div class="modal-footer">
                <button type="button"  class="btn btn-danger" data-dismiss="modal"> Close </button>
                <button v-show="editMode" type="submit" class="btn btn-primary">Update</button>
                <button v-show="!editMode" type="submit" class="btn btn-primary">Create</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {  
      editMode: true,
      users: {},
      form: new Form({
        id:"",
        name: "",
        email: "",
        password: "",
        type: "",
        bio: "",
        photo: "",
      }),
    };
  },
  methods: {
    editModal(user) {
      this.editMode = true;
      this.form.clear();
      this.form.reset();
      $("#exampleModal").modal("show");
      this.form.fill(user);
    },
    updateUser(){

      this.$Progress.start();
      this.form.put('api/user/'+this.form.id)
      .then(() => {
        swal.fire("Updated!", "Inforamtion has been Updated.", "success");
         $("#exampleModal").modal("hide");
          this.$Progress.finish();
          Fire.$emit("loadUser");
      })  
      .catch(()=> {
        this.$Progress.fail();
      });

      
    },
    newModal() {  
      this.editMode = false;
      this.form.clear();
      this.form.reset();
      $("#exampleModal").modal("show");
    },
    deleteUser(id) {
      swal
        .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        })
        .then((result) => {
          if (result.isConfirmed) {
            this.form.delete("api/user/" + id).then(() => {
              Fire.$emit("loadUser");
              swal.fire("Deleted!", "Data has been deleted.", "success");
            }).catch(() => swal.fire("Failed!", "There was something wrong.", "warning"));
          }
        })
        .catch(() => {
          swal.fire("Failed!", "There was something wrong.", "warning");
        });
    },
    loadUsers() {
      axios.get("api/user").then(({ data }) => (this.users = data.data));
    },
    createUser() {
      this.$Progress.start();
      this.form
        .post("api/user")
        .then(() => {
          $("#exampleModal").modal("hide");
          Fire.$emit("loadUser");
          toast.fire({
            icon: "success",
            title: "Signed in successfully",
          });
        })
        .catch();

      this.$Progress.finish();
    },
  },
  created() {
    this.loadUsers();
    Fire.$on("loadUser", () => this.loadUsers());
    //   setInterval(() => this.loadUsers(),3000);
  },
};
</script>
