## BrickList ##

Creates a list of bricks of that helps create a Lego mosaic.

### Usage ###

Input image: [`sample/earth.png`](https://github.com/rustyfausak/bricklist/blob/master/sample/earth.png)

![Earth mosaic original](https://raw.githubusercontent.com/rustyfausak/bricklist/master/sample/earth.png "Earth mosaic original")

Input tiles file: [`sample/tiles.txt`](https://github.com/rustyfausak/bricklist/blob/master/sample/tiles.txt)

Run this on the command line:

```
$ php bricklist.php sample/tiles.txt sample/earth.png
```

Creates [`sample/output-earth.csv`](https://github.com/rustyfausak/bricklist/blob/master/sample/output-earth.csv) that contains the brick list:

```csv
color,brick,quantity
black,plate,1
white,1x1,11
lime,2x4,4
lime,1x1,43
blue,2x4,10
blue,1x1,47
```

Also creates an image [`sample/output-earth.png`](https://github.com/rustyfausak/bricklist/blob/master/sample/output-earth.png) that shows where the bricks can be placed:

![Earth mosaic brick placement](https://raw.githubusercontent.com/rustyfausak/bricklist/master/sample/output-earth.png "Earth mosaic brick placement")

### Tiles File ###

You can use the sample tiles file or create one to suit your needs. It contains the brick sizes and colors that are allowed when creating the brick list for a mosaic. For example, if you want a monochrome mosaic of 1x1 bricks, you could use this tile file [`sample/monochrome.txt`](https://github.com/rustyfausak/bricklist/blob/master/sample/monochrome.txt):

```
1x1, white#FFFFFF
1x1, light gray#9C9C9C
1x1, dark gray#595D60
plate, black#000000
```

And if we applied this tile file to the sample [`sample/earth.png`](https://github.com/rustyfausak/bricklist/blob/master/sample/earth.png) image:

```
$ php bricklist.php sample/monochrome.txt sample/earth.png
```

It would create this [`sample/output-earth-monochrome.csv`](https://github.com/rustyfausak/bricklist/blob/master/sample/output-earth-monochrome.csv):

```csv
color,brick,quantity
black,plate,1
white,1x1,11
"light gray",1x1,75
"dark gray",1x1,127
```

And this placements image: [`sample/output-earth-monochrome.png`](https://github.com/rustyfausak/bricklist/blob/master/sample/output-earth-monochrome.png)

![Earth mosaic brick placement monochrome](https://raw.githubusercontent.com/rustyfausak/bricklist/master/sample/output-earth-monochrome.png "Earth mosaic brick placement monochrome")

Colors are automatically applied to the source image.

## Source Image ##

Your source image should contain 1 pixel for each 1x1 brick size. Check the sample folder for examples:

![Sample mosaic](https://github.com/rustyfausak/bricklist/blob/master/sample/jupiter.png)
![Sample mosaic](https://github.com/rustyfausak/bricklist/blob/master/sample/saturn.png)
