# Main nav — placement

## Drop in as-is
```
resources/views/coming-soon.blade.php
resources/views/partials/nav.blade.php
```

## Merge by hand
```
snippets/routes-web-additions.txt  -> merge into routes/web.php
snippets/layout-include.txt        -> add one @include line to your layout
```

## Steps
1. Copy the two new view files into place.
2. Merge the routes snippet (skip the rulesheets.* lines if you already
   added those from the earlier deliverable).
3. Add the one @include('partials.nav') line to your layout per
   layout-include.txt.
4. Visit any page — you should see the top nav with all six items;
   Locations/Calendar/Show Simulator/Account/About all hit the shared
   Coming Soon page, Rulesheets goes to the real search page.
5. Resize the browser (or check on your phone) to confirm the hamburger
   toggle works below the md breakpoint.

Active-state highlighting (current section shown in blue) is handled via
request()->routeIs() matching the route name's prefix — so once
locations.index becomes a real controller instead of Route::view(), as
long as you keep the route name locations.index and add real
locations.* routes alongside it, the highlighting keeps working with no
changes to the nav partial.
