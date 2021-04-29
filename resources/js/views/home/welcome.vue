<template>
  <div class="grid">
    <div>
      <img src="/storage/assets/media/images/system/welcome.svg" class="img" />
    </div>
    <div class="showcase card">
      <div class="img_container">
        <div class="circle_pulse">
          <img
            src="/storage/assets/media/images/system/logo.jpg"
            alt="MHM logo"
            id="logo"
          />
        </div>
      </div>
      <div class="hero">
        <h1>
          <span id="let-1">W</span><span id="let-2">e</span
          ><span id="let-3">l</span><span id="let-4">c</span
          ><span id="let-5">o</span><span id="let-6">m</span
          ><span id="let-7">e</span>
        </h1>
      </div>
      <div class="btn">
        <a href="/login" class="nav-link">Enter</a>
      </div>
      <div class="btn">
        <a href="/register" class="nav-link">Register</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "welcome",
};
</script>

<style scoped>
* {
  padding: 0;
  margin: 0;
  text-decoration: none;
  list-style: none;
  box-sizing: border-box;
}
:root {
  --primary-color: #0082e6;
  --hover-color: #1b9bff;
  --nav-side-color: #2c3e50;
  --scren_width: 100vw;
}
body {
  font-family: Verdana, Geneva, Tahoma, sans-serif;
}
.img {
  width: 50vw;
  height: 100vh;
  display: absolute;
  left: 0;
  padding: 0;
  top: 0;
}
.showcase {
  /* position: absolute; */
  width: auto;
  height: 100vh;
  /* right:0;
              top:0; */
  /* align-content: center; */
}
.grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 10px;
  /* justify-content: center; */
  /* align-items: center; */
  /* height: 100%; */
}
/*.card {*/
/*  background-color: #fff;*/
/*  color: #333;*/
/*  border-radius: 10px;*/
/*  !* box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.2); *!*/
/*  padding: 20px;*/
/*  margin: 10px;*/
/*}*/
.showcase h1 {
  font-size: 25px;
  font-weight: lighter;
  letter-spacing: 5px;
  color: rgb(39, 207, 254);
  text-align: center;
  animation-name: heads;
  animation-duration: 2s;
  animation-fill-mode: forwards;
}
a {
  text-decoration: none;
  font-size: large;
  color: #0093d7;
}

.btn:hover {
  animation: skeez 0.4s forwards;
}
.img_container {
  width: 200px;
  height: 200px;
  padding: 5px;
  margin: 0 auto;
  animation: bounce 0.5s cubic-bezier(0.5, 0.05, 1, 1);
  animation-direction: alternate;
  animation-iteration-count: 5;
}
.circle_pulse {
  width: 175px;
  height: 175px;
  border: 2px solid rgb(39, 207, 254);
  border-radius: 50%;
  margin: 5px;
  box-shadow: 0 0 0 0 rgba(39, 207, 254);
  animation: pulse 1.3s infinite;
  animation-delay: 1.9s;
}
#logo {
  display: block;
  width: 115px;
  height: 115px;
  margin: 0 auto;
  margin-top: 25px;
}
.hero h1 {
  margin: 20px;
}

span {
  font-size: 3em;
  display: inline-block;
}
div:hover span {
  animation: 2s letters infinite;
}
#let-2 {
  animation-delay: 0.1s;
}
#let-3 {
  animation-delay: 0.2s;
}
#let-4 {
  animation-delay: 0.3s;
}
#let-5 {
  animation-delay: 0.4s;
}
#let-6 {
  animation-delay: 0.5s;
}
#let-7 {
  animation-delay: 0.6s;
}
#let-8 {
  animation-delay: 0.7s;
}
#let-9 {
  animation-delay: 0.8s;
}
#let-10 {
  animation-delay: 0.9s;
}
@-webkit-keyframes letters {
  from,
  to {
    transform: scale(1);
  }
  50% {
    transform: scale(1.3);
  }
}
@keyframes letters {
  from,
  to {
    transform: scale(1);
  }
  50% {
    transform: scale(1.3);
  }
}

@keyframes bounce {
  0% {
    transform: translate3d(0, -150px, 0);
  }
  100% {
    transform: translate3d(0, 0px, 0);
  }
}

@keyframes pulse {
  to {
    box-shadow: 0 0 0 18px rgba(39, 207, 254, 0.01);
  }
}
@keyframes skeez {
  0% {
    transform: translateX(0px);
  }
  20% {
    transform: translateX(-10px);
  }
  40% {
    transform: translateX(10px);
  }
  60% {
    transform: translateX(-10px);
  }
  80% {
    transform: translateX(10px);
  }
  100% {
    transform: translateX(0px);
  }
}
@media (max-width: 750px) {
  .showcase h1 {
    font-size: 15px;
    font-weight: bold;
    color: rgb(39, 207, 254);
  }
  .img {
    display: none;
  }
  .grid {
    grid-template-columns: 100%;
  }
}
</style>
