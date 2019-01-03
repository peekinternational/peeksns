<template>
    <div class="col-md-3">
	       <div class="cards cards-user">
						<div class="image">
							<img :src="'/profile-photos/logo/background.jpg'" alt="...">
						</div>
						<div class="content">
							<div class="author">
							<div class="re-img-box" v-if="showimgs" style="border-radius: 0px !important;height:100px">
									<img class="avatar border-white" :src="'/profile-photos/'+showimgs" alt="..." style="margin-left: 98px;">
									
									</div>
                  <div class="re-img-box" v-else>
									<img class="avatar border-white" :src="'/profile-photos/logo/new_logo.png'" alt="..." style="margin-left: 98px;">
									
									</div>
								<h4 class="title" id="userName">Nabeel<br>

								</h4>
                <div>
                <span style="float:left">Post</span>
                </div>
							</div>

						</div>
						<hr>
						<div class="text-center">
							<div class="row">

							</div>
						</div>
					</div>
     </div>
</template>
<script>
export default {
    props:['showdata',
            'showimgs',
            'userinfo',
            'userimg'],
}
</script>
<style lang="">
  
.left-sidebar ul li a svg {
    margin-right: 10px;
    height: 20px;
    width: 20px;
    vertical-align: middle;
    margin-top: -3px;
}
.cards-user .image {
    border-radius: 8px 8px 0 0;
    height: 150px;
    position: relative;
    overflow: hidden;
}

.cards-user .image img {
    width: 100%;
}

.cards-user .image-plain {
    height: 0;
    margin-top: 110px;
}

.cards-user .author {
    text-align: center;
    text-transform: none;
    margin-top: -65px;
}

.cards-user .author .title {
    color: #403D39;
}

.cards-user .author .title small {
    color: #ccc5b9;
}

.cards-user .avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    position: relative;
    margin-bottom: 15px;
}

.cards-user .avatar.border-white {
    border: 5px solid #FFFFFF;
}

.cards-user .avatar.border-gray {
    border: 5px solid #ccc5b9;
}

.cards-user .title {
    font-weight: 600;
    line-height: 24px;
}

.cards-user .description {
    margin-top: 10px;
}

.cards-user .content {
    min-height: 200px;
}

.cards-user.cards-plain .avatar {
    height: 190px;
    width: 190px;
}
.cards {
    border-radius: 6px;
    box-shadow: 0 2px 2px rgba(204, 197, 185, 0.5);
    background-color: #FFFFFF;
    color: #252422;
    margin-bottom: 20px;
    position: relative;
    z-index: 1;
}

.cards .image {
    width: 100%;
    overflow: hidden;
    height: 260px;
    border-radius: 6px 6px 0 0;
    position: relative;
    -webkit-transform-style: preserve-3d;
    -moz-transform-style: preserve-3d;
    transform-style: preserve-3d;
}
</style>