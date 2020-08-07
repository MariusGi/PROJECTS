$('.btn-start-game').on('click', function() {
    $('.game-rules').hide();
    $('.moving-object-container').append('<div class="moving-object"></div>');
    animateDiv();
});

//=====================================================================================================================
// MOVING OBJECT
//=====================================================================================================================

function animateDiv() {
    let newq = makeNewPosition();
    let movingObject = $('.moving-object');
    let oldq = movingObject.offset();
    let speed = calcSpeed([oldq.top, oldq.left], newq);

    movingObject.animate({ top: newq[0], left: newq[1] }, speed, function() {
        animateDiv();
    });
}

function makeNewPosition() {
    // Get viewport dimensions (remove the dimension of the div)
    let height = $('.moving-object').height();
    let width = $('.moving-object').width();
    console.log(height);
    console.log(width);
    let newHeight = Math.floor(Math.random() * height);
    let newWidth = Math.floor(Math.random() * width);

    return [newHeight, newWidth];
}

function calcSpeed(prev, next) {
    let x = Math.abs(prev[1] - next[1]);
    let y = Math.abs(prev[0] - next[0]);
    let greatest = x > y ? x : y;
    let speedModifier = 0.1;

    return Math.ceil(greatest / speedModifier);
}

//=====================================================================================================================
// END OF MOVING OBBJECT
//=====================================================================================================================
