## BrickList ##

Creates a list of bricks of that helps create a Lego mosaic.

### Usage ###

Input image:

![Earth mosaic original](https://raw.githubusercontent.com/rustyfausak/bricklist/master/sample/earth.png "Earth mosaic original")

Input tiles file: [sample/tiles.txt](https://raw.githubusercontent.com/rustyfausak/bricklist/master/sample/tiles.txt)

Run this on the command line:

```
$ php bricklist.php sample/tiles.txt sample/earth.png
```

Creates `output.csv` that contains the brick list:

```csv
color,brick,quantity
black,2x4,93
black,1x1,67
white,2x4,0
white,1x1,11
lime,2x4,4
lime,1x1,43
blue,2x4,10
blue,1x1,47
```

Also creates an image `output-earth.png.png` that shows where the bricks can be placed:

![Earth mosaic brick placement](https://raw.githubusercontent.com/rustyfausak/bricklist/master/sample/output-earth.png.png "Earth mosaic brick placement")

### Tiles File ###

You can use the sample tiles file or create one to suit your needs. It contains the brick sizes and colors that are allowed when creating the brick list for a mosaic. For example, if you want just a black and white mosaic of 1x1 bricks, you could use this tile file:

```
1x1, white#FFFFFF
1x1, black#000000
```

And if we applied this tile file to the sample `earth.png` image:

```
$ php bricklist.php sample/bw1x1.txt sample/earth.png
```

It would create this `output.csv`:

```csv
color,brick,quantity
black,1x1,938
white,1x1,86
```

And this placements image:

![Earth mosaic brick placement black/white](https://raw.githubusercontent.com/rustyfausak/bricklist/master/sample/output-earth-bw.png.png "Earth mosaic brick placement black/white")

Colors are automatically applied intelligently to the source image.

## Source Image ##

Your source image should contain 1 pixel for each 1x1 brick size. Check the sample folder for examples:

![Sample mosaic](https://github.com/rustyfausak/bricklist/blob/master/sample/jupiter.png)
![Sample mosaic](https://github.com/rustyfausak/bricklist/blob/master/sample/saturn.png)
