<div id="windowModal" class="window-modal-bck hidden">
    <div class="relative">
    <div class="hack-center window-white z-index-900" style="filter: blur(0);">
        <div class="_head flex space-btw">
            <p class="flex-center"></p>
            <a href="#!" onclick="removeModal()">
                <img class="icon" src="<?php echo IMAGES."icons/close.svg"?>" alt="close" width="30" height="30">
            </a>
        </div>
        <div class="_body">
        </div>
    </div>
    </div>
</div>
<div class="modal-free window-modal-bck hidden" onclick="toggle('.modal-free','hidden')">
</div>




<div class="poster-container hidden" id="poster-container">
    <a href="#!" onclick="toggle('#poster-container','hidden')" class="button-close-poster flex-center">
        <i class="fas fa-times"></i>
    </a>
    <div class="content">
    </div>
</div>