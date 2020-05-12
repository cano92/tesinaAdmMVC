var app = new Vue({
  el: '#app',
  data: {
    tesinas: []
  },
  delimiters: ["<%","%>"],
  });


var estado =new Vue({
  el: "#estado",
  data: {
    key: "",
  },
  methods: {
  	onchange: function() {
      console.log(this.key);
      
      var url="https://grupo54.proyecto2018.linti.unlp.edu.ar/slim-app/public/api/tesinas/"+encodeURIComponent(this.key);
      
      axios.get(url)
        .then(response => {
          // JSON responses are automatically parsed.
          app.tesinas = response.data;
        })
        .catch(e => {
          app.errors.push(e)
        })

    }
  }
});

function foo(leg){
  alert(leg);
};

var legajo =new Vue({
  el: "#legajo",
  data: {
    leg: "",
  },
  delimiters: ["<%","%>"],
  methods: {
    checkExist(event){

      var url="https://grupo54.proyecto2018.linti.unlp.edu.ar/slim-app/public/api/tesinas/alumno/"+encodeURIComponent(event.target.value);

      axios.get(url)
        .then(response => {
          // JSON responses are automatically parsed.
          app.tesinas = response.data;
          
        })
        .catch(e => {
          app.errors.push(e)
        })

    }
  }  
  
});