<style lang="scss">
.post-component{
    .panel{
        display: inline-block;
        max-width: 300px;
        min-width: 300px;
        min-height: 300px;
        float: left;
        margin: 5px;
    }

    .red{
        color: red;
    }
}
</style>
<template>
	<div class="post-component ">
        <h1>Post component</h1>
        

        <div class="form-group">
            
            <label for="input-title">Título</label>
            <input type="text" class="form-control" id="input-title" v-model="form.title" placeholder="Escribe un título">
            <!-- <span class="red" v-if="errors.title.length>0">
                <small v-for="error in errors.title">
                    {{error}}
                    <br>
                </small>
            </span> -->
        </div>
        <div class="form-group" :class="{'has-error' : errors.description.length>0 }">
            
            <label for="input-description">Descripción</label>
            <textarea name=""class="form-control"  id="" cols="30" rows="10" v-model="form.description"></textarea>
            <!-- <span class="red" v-if="errors.description.length>0">
                <small v-for="error in errors.description">
                    {{error}}
                    <br>
                </small>
            </span> -->
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input v-model="form.published" type="checkbox"> Published
                </label>
            </div>

        </div>

        <button class="btn btn-success" @click.prevent="createPost">Crear post</button>
        <br><br>
        
        <button type="button" class="btn primary" :disabled="!collection.prev_page_url" @click="move('prev_page_url')">Anterior</button>
        <button type="button" class="btn primary" :disabled="!collection.next_page_url" @click="move('next_page_url')">Siguiente</button>


        <div class="content">
            <div class="panel panel-default" v-for="post in orderedPosts">
                <div class="panel-heading">
                    <span v-text="post.title"></span><br>
                    <span class="label" :class="{'label-default' : !post.published, 'label-success' : post.published }">{{post.published? 'Published' : 'Unpublished'}}</span>
                </div>
                <div class="panel-body" >
                    <p v-text="post.description"></p>
                    <button type="button" class="btn btn-danger" @click="deletePost(post)">Eliminar</button>
                    <div class="checkbox">
                        <label>
                            <input v-model="post.published" type="checkbox"> Published
                        </label>
                    </div>
                </div>
            </div>
        </div>
	</div>
</template>
<script>
// import PostValidator from '../validators/PostValidator.js'
// import Service from 'easy-requests'

// class Post extends Service
// {
//     constructor(){
//         super();
//     }

//     nextPage(url){
//         return new Promise((resolve, reject)=>{
//             this
//                 .http
//                 .get(url)
//                 .then(response =>{
//                     resolve(response.data)
//                 })
//                 .catch(err=>{
//                     reject(err)
//                 })
//         });
//     }
// }

// let PostService = new Post();

  export default {
    data() {
      return{
        posts : [],
        collection : { next_page_url : null, prev_page_url : null},
        form : {
            title : null,
            description : null,
            published :  null,
            user_id : 1
        },
        errors : {
            title : [],
            description : []
        }
      }
    },
    methods :{
        resetInputs(){
            this.form = {
                title : null,
                description : null,
                published :  null,
                user_id : 1       
            }
        },
        move(to){
            let toPage = this.collection[to];
            if(toPage){
                this.movePage(toPage)
            }
        },
        movePage(url){
            let vm = this;

            axios.get(url)
            .then((posts)=>{
                vm.posts = posts.data.data;
                vm.collection = posts.data
            })

            // if(!url) throw "We have not received any url!"

            // let post_promise = PostService.nextPage(url);    

            // post_promise.then((posts)=>{
            //     vm.posts = posts.data;
            //     vm.collection = posts
            // })
            // .catch(err =>{
            //     console.log("There was an error ", err)
            // })
        },
        //async 
        getPosts(params = { page : 3 }){
            let vm = this;
            
            axios.get("posts", {params})
            .then((posts)=>{
                vm.posts = posts.data.data;
                vm.collection = posts.data
            })

            // let posts = await PostService.get(params);
            // this.posts = posts.data;
            // this.collection = posts
        },
      createPost(){
         let vm = this;

         //OPtion 1

         // let rules = {
         //    title : 'required',
         //    description  : ['required']
         // }

         // let data = this.form;

         // let validation = Validator.make(data,rules);

         // if(validation.fails()){
         //    console.log(validation.messages)

         //    return;
         // }


         //Option 2

        // let validator = PostValidator.make(this.form);

        // this.errors = validator.messages;

        // if(validator.fails()){
        //     console.log(validator.messages)
        //     return ;
        // }


        axios.post("posts", this.form).then((new_post)=>{
            vm.posts.push(new_post.data);
            vm.reset();
        }).catch(error =>{
            console.log("Error");
        });

      },
      deletePost(post){
        let index = this.posts.map(p => p.id).indexOf(post.id);
        let vm = this;
        axios.delete("posts/"+post.id).then((new_post)=>{
            vm.posts = vm.posts.filter(p => p.id != post.id);
        });
      },
    },
    mounted(){
      this.getPosts();
    },
    computed : {
        orderedPosts(){
            return _.orderBy(this.posts,['id'],['desc'])
        }

    }
  }
</script>