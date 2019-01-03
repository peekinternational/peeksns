<template>
<section id="relate-to-job" style="margin-top:60px" >
    <div class="container">
    <div class="row">
       <liftside></liftside>
        <div class="col-md-6 posts-user">
        <div class="col-md-12" style="background-color: white;padding: 1px;margin-bottom: 13px;">
        <h2 style="text-align: center;">Latest News</h2>
        </div>
        <div class="col-md-4 posts-user" v-for="allnews in news" style="margin-bottom: 7px;">
        
        <div class="card" style="width: 19rem;background-color: white;padding: 10px">
        <router-link :to="{ name: 'pernews', params: { news_id: allnews.newsId}}">
        <img  class="card-img-top" :src="'http://203.99.61.173/demos/peeksns/public/featured-photos/'+allnews.featuredImage" style="width:100%;
            box-shadow: 0 2px 6px 0px rgba(50, 50, 50, 0.14);
            margin-bottom: 10px;
            border-radius: 4px;">
  
      <div class="card-body">
        <h4 class="card-title" style="color:black">{{allnews.title}}</h4>
    
      </div>
      </router-link>
       <p class="card-text" v-if="allnews.newsData.length>=8" >{{ allnews.newsData.substring(0,8)+".."  }}</p>
       </div>
         

         </div>
       
     </div>
     <rightside :showimgs="showimg"></rightside>
    </div>
   </div>
   </section>
</template>
<script>
export default {
 props:['showdata',
            'showimg',
            'userinfo',
            'userimg'],
    data() {
        return {
            news:{},
        }
    },
    methods: {
         getperdata(){
                    axios.get('http://203.99.61.173/demos/peeksns/public/account/news/')
                  .then((responce) => {
                    this.news=responce.data;
                    console.log(responce.data)
                  })
                  .catch((error) => console.log(error));
         }
    },
    mounted() {
        this.getperdata();
    },
}
</script>
<style>

</style>