<template>
    <section id="relate-to-job" style="margin-top:100px" >
    <div class="container">
    <div class="row">
       <div class="col-md-2 leftcol watch_info_movie" style="position: relative; overflow: visible; box-sizing: border-box; min-height: 424.828px;">
			
		<div class="theiaStickySidebar" ><div class="played-film-image-wrap">
				<img alt="National Assembly information report " title="National Assembly information report " :src="'http://203.99.61.173/demos/peeksns/public/featured-photos/'+showdata.featuredImage">
				<h4 class="main"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{showdata.title}}</font></font></h4>
				<div>
					<p class="m-mata-tag"><span><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Genre</font></font></span></p>
					<p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">News</font></font></p>
				</div>
				
				<div>
					<p><span class="m-mata-tag"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Share to</font></font></span></p>
					<p class="share-film">
						<a href="https://www.facebook.com/sharer/sharer.php?u=https://www.talksns.com/movies/watch/7/" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="feather feather-facebook" fill="#337ab7"><path d="M5,3H19A2,2 0 0,1 21,5V19A2,2 0 0,1 19,21H5A2,2 0 0,1 3,19V5A2,2 0 0,1 5,3M18,5H15.5A3.5,3.5 0 0,0 12,8.5V11H10V14H12V21H15V14H18V11H15V9A1,1 0 0,1 16,8H18V5Z"></path></svg>
						</a>
						<a href="https://twitter.com/intent/tweet?text=https://www.talksns.com/movies/watch/7/" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="feather feather-twitter" fill="#55acee"><path d="M5,3H19A2,2 0 0,1 21,5V19A2,2 0 0,1 19,21H5A2,2 0 0,1 3,19V5A2,2 0 0,1 5,3M17.71,9.33C18.19,8.93 18.75,8.45 19,7.92C18.59,8.13 18.1,8.26 17.56,8.33C18.06,7.97 18.47,7.5 18.68,6.86C18.16,7.14 17.63,7.38 16.97,7.5C15.42,5.63 11.71,7.15 12.37,9.95C9.76,9.79 8.17,8.61 6.85,7.16C6.1,8.38 6.75,10.23 7.64,10.74C7.18,10.71 6.83,10.57 6.5,10.41C6.54,11.95 7.39,12.69 8.58,13.09C8.22,13.16 7.82,13.18 7.44,13.12C7.81,14.19 8.58,14.86 9.9,15C9,15.76 7.34,16.29 6,16.08C7.15,16.81 8.46,17.39 10.28,17.31C14.69,17.11 17.64,13.95 17.71,9.33Z"></path></svg>
						</a>
						<a href="https://plus.google.com/share?url=https://www.talksns.com/movies/watch/7/" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="feather feather-google" fill="#d9534f"><path d="M5,3H19A2,2 0 0,1 21,5V19A2,2 0 0,1 19,21H5A2,2 0 0,1 3,19V5A2,2 0 0,1 5,3M19.5,12H18V10.5H17V12H15.5V13H17V14.5H18V13H19.5V12M9.65,11.36V12.9H12.22C12.09,13.54 11.45,14.83 9.65,14.83C8.11,14.83 6.89,13.54 6.89,12C6.89,10.46 8.11,9.17 9.65,9.17C10.55,9.17 11.13,9.56 11.45,9.88L12.67,8.72C11.9,7.95 10.87,7.5 9.65,7.5C7.14,7.5 5.15,9.5 5.15,12C5.15,14.5 7.14,16.5 9.65,16.5C12.22,16.5 13.96,14.7 13.96,12.13C13.96,11.81 13.96,11.61 13.89,11.36H9.65Z"></path></svg>
						</a>
					</p>
				</div>
			</div></div></div>
       <div class="col-md-7">
       <div class="played-film-description-wrapper" style="padding-left: 8px;padding-right: 8px;">
				<div>
					<h2 class="movie-title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{showdata.title}}</font></font></h2>
					<ul class="breadcrumb watch-film-top-nav hidden-xs">
						<li><a href=""><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> Home</font></font></a></li>
						<li><a href=""><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">News</font></font></a></li>
						
						<li class="last-bread"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{showdata.title}}</font></font></li>
					</ul>
					<div class="film-player-wrapper">
													<div class="watch_player_movie">
								<iframe :src="'https://www.youtube.com/embed/'+showdata.news_resource" frameborder="0" width="100%" height="391px"></iframe>
							</div>
											</div>
					<div class="played-film-description">
						<div class="played-film-meta">
							<p class="about-film"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{ showdata.newsData | striphtml }} </font></font><br> <br><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">[Source: JoongAng Ilbo] Competition of the Korean party headquarters · Will the three-faced Na Kyung-won 3 be successful?</font></font></p>
							 <div class="played-film-details">
								<ul class="col-md-12">
									<li>
										<p>
											<span class="m-mata-tag"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Stars: </font></font></span>
											<span class="main"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Cho Moon-gyu</font></font></span>
										</p>
									</li>
									<li>
										<p>
											<span class="m-mata-tag"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Quality: </font></font></span>
											<span class="badge"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">CAM</font></font></span>
										</p>
									</li>
									<li class="mobi_movi_category">
										<p>
											<span class="m-mata-tag"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Genre: </font></font></span>
											<span class="main"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">TVSHOW</font></font></span>
										</p>
									</li>
									
									<li>
										<p>
											<span class="m-mata-tag"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Views: </font></font></span>
											<span class="main"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">8</font></font></span>
										</p>
									</li>
								</ul>
							</div>
						</div>
					</div>
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
     name: 'pernews',
    props: ['news_id',
    'showimg',],
    data() {
        return {
            showdata:'',
        }
    },
    methods: {
        
         getperdata(){
                    axios.get('http://203.99.61.173/demos/peeksns/public/account/news/'+this.news_id)
                  .then((responce) => {
                    this.showdata=responce.data[0];
                  })
                  .catch((error) => console.log(error));
         }
    },
    mounted() {
            console.log(this.news_id);
            this.getperdata();
        },
}
</script>
<style lang="">
    .played-film-description-wrapper {
    background-color: #fff;
    overflow: hidden;
    box-shadow: 0 1px 0 0 #e3e4e8, 0 0 0 1px #f1f1f1;
}
.related-movies-container {
    background-color: #fff;
    overflow: hidden;
    box-shadow: 0 1px 0 0 #e3e4e8, 0 0 0 1px #f1f1f1;
    margin-top: 1px;
}
.played-film-image-wrap {
    display: block;
    overflow: hidden;
    position: relative;
    background-color: white;
    border-radius: 3px;
    box-shadow: 0 1px 0 0 #e3e4e8, 0 0 0 1px #f1f1f1;
    padding: 8px;
}
.responsive-img {
    width: 100%;
    max-width: 100%;
}
.main {
    color: #5a9e02 !important;
}
</style>