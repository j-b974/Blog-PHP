<?php

function e(string $portection)
{
    return htmlentities($protection);
}
function color(string $nom): ?string
{
    $int = random_int(1,6);
    switch ($int) {
        case 1:
            return 'success';
        case 2:
                return 'dark';
        case 3:
            return 'warning';
        case 4:
            return 'secondary';
        case 5:
        return 'danger';
        case 6 :
            return 'info';
        default:
        return null;
    }
}
function is_cat_active(?string $active) : ?string
{
    if($active === 'cat')
    {
        return 'active';
    }
    return null;
}
function is_post_active(?string $active): ?string
{
    if($active ==='post')
    {
        return 'active';
    }
    return null;
}