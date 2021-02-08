<style>
.widget-user-header {
  background-position: center center;
  background-size: cover;
  height: 250px;
}
</style>

<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-widget widget-user">
          <!-- Add the bg  color to the header using any of the bg-* classes -->
          <div
            class="widget-user-header text-white"
            style="background: url('./img/user-cover.jpg') center center"
          >
            <h3 class="widget-user-username text-right">Elizabeth Pierce</h3>
            <h5 class="widget-user-desc text-right">Web Designer</h5>
          </div>
          <div class="widget-user-image">
            <img class="img-circle" src="" alt="User Avatar" />
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">3,200</h5>
                  <span class="description-text">SALES</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">13,000</h5>
                  <span class="description-text">FOLLOWERS</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-4">
                <div class="description-block">
                  <h5 class="description-header">35</h5>
                  <span class="description-text">PRODUCTS</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
        </div>

        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item">
                <a class="nav-link active" href="#activity" data-toggle="tab"
                  >Activity</a
                >
              </li>

              <li class="nav-item">
                <a class="nav-link" href="#settings" data-toggle="tab"
                  >Settings</a
                >
              </li>
            </ul>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="activity"></div>

              <div class="tab-pane" id="settings">
                <form class="form-horizontal">
                  <div class="form-group row">
                    <label for="inputName" class="col-sm-2 col-form-label"
                      >Name</label
                    >
                    <div class="col-sm-10">
                      <input
                        v-model="form.name"
                        type="text"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('name') }"
                        id="inputName"
                        placeholder="Name"
                      />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail" class="col-sm-2 col-form-label"
                      >Email</label
                    >
                    <div class="col-sm-10">
                      <input
                        v-model="form.email"
                        type="email"
                        id="inputEmail"
                        placeholder="Email"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('email') }"
                      />
                      <has-error :form="form" field="email"></has-error>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputName2" class="col-sm-2 col-form-label"
                      >Type</label
                    >
                    <div class="col-sm-10">
                      <input
                        v-model="form.type"
                        type="text"
                        class="form-control"
                        id="inputName2"
                        placeholder="Type"
                      />
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="photo" class="col-sm-2 col-form-label"
                      >Profile Photo</label
                    >
                    <div class="col-sm-10">
                      <input
                        @change="updateProfile"
                        type="file"
                        class="form-control"
                        id="inputName2"
                        placeholder="Type"
                      />
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputExperience" class="col-sm-2 col-form-label"
                      >Bio</label
                    >
                    <div class="col-sm-10">
                      <textarea
                        v-model="form.bio"
                        class="form-control"
                        id="inputExperience"
                        placeholder="bio"
                      ></textarea>
                      <has-error :form="form" field="bio"></has-error>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputName2" class="col-sm-2 col-form-label"
                      >Password</label
                    >
                    <div class="col-sm-10">
                      <input
                        v-model="form.password"
                        type="password"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('password') }"
                        id="inputName2"
                        placeholder="Password"
                      />
                      <has-error :form="form" field="password"></has-error>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" /> I agree to the
                          <a href="#">terms and conditions</a>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <button
                        class="btn btn-success"
                        type="submit"
                        @click.prevent="updateInfo"
                      >
                        Update
                      </button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.nav-tabs-custom -->
      </div>
    </div>
  </div>
</template>



<script>
export default {
  data() {
    return {
      form: new Form({
        id: "",
        name: "",
        email: "",
        password: "",
        type: "",
        bio: "",
        photo: "",
      }),
    };
  },
  mounted() {
    console.log("Component mounted.");
  },
  methods: {
    updateInfo() {
      this.form
        .put("api/profile")
        .then(() => {})
        .catch((e) => console.log(e));
    },
    updateProfile(e) {
      let file = e.target.files[0];
      let reader = new FileReader();
      let limit = 1024 * 1024 * 2;
      if (file["size"] > limit) {
        swal({
          type: "error",
          title: "Oops...",
          text: "You are uploading a large file",
        });
        return false;
      }
      reader.onloadend = (file) => {
        this.form.photo = reader.result;
      };
      reader.readAsDataURL(file);
    },
  },
  created() {
    axios.get("api/profile").then(({ data }) => this.form.fill(data));
  },
};
</script>
