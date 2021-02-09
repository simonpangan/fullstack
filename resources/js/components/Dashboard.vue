<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
               
                <not-found></not-found>
            </div>
        </div>
    </div>
</template>

<script>
// import NotFound from './NotFound.vue' // dont need to import cause global
export default {
  //   components: { NotFound }, // dont need to import cause global
  mounted() {
    console.log("Component mounted.");
  },
};
</script>
