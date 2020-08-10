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
    // let speed = calcSpeed([oldq.top, oldq.left], newq);
    movingObject.animate({ top: newq[0], left: newq[1] }, 1000, function() {
        animateDiv();
    });
}

function makeNewPosition() {
    // Get viewport dimensions (remove the dimension of the div)
    let movingObject = $('.moving-object');
    let top = Math.random() * (10 - 5) + 5
    let left = movingObject.position().left;
    let newTop = (Math.random() * (1.1 - 0.9) + 0.9) * top;
    let newLeft = (Math.random() * (1.05 - 0.95) + 0.95) * left;

    return [newTop, newLeft];
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
