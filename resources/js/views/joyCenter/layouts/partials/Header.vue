<template>
  <div>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
      <div class="container-fluid">
        <router-link :to="{ name: 'joyHome' }" class="navbar-brand" href="#">
          JoyCenter
        </router-link>
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->
          <ul class="navbar-nav ml-4 mr-auto">
            <li class="nav-item">
              <router-link
                :to="{ name: 'patients.crud' }"
                class="nav-link"
                href=""
                >Patients</router-link
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" href="">Queue</a>
            </li>

            <li class="nav-item dropdown" id="navOrder">
              <a
                href="#"
                class="nav-link dropdown-toggle"
                data-toggle="dropdown"
                role="button"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <i class="glyphicon glyphicon-plus-sign"></i> Consultation
                <span class="caret"></span
              ></a>
              <ul class="dropdown-menu">
                <router-link :to="{name:'consultation.new'}" class="dropdown-item">
                  <i class="glyphicon glyphicon-plus"></i> Consultation</router-link
                >
                <a href="" class="dropdown-item">
                  <i class="glyphicon glyphicon-plus"></i> GDOC</a
                >
              </ul>
            </li>

            <li id="navReport" class="nav-item">
              <a class="nav-link">
                <i class="glyphicon glyphicon-check"></i> Cash
              </a>
            </li>
            <li id="sendinfo" class="nav-item">
              <a href="" class="nav-link">
                <i class="glyphicon glyphicon-edit"></i> Send Info
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
export default {
  name: "Header",
};
</script>

<style scoped>
</style>
