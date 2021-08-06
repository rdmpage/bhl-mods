# bhl-mods

Import BHL MODs file to extract information on BHL titles


## Series

While BHL usually groups volumes from the same journal together, if those volumes are monographs they may be treated as standalone titles. On the BHL web site the “series” field often gives a clue as to the journal the titles belong to. This information may be in the MODs file in the `<relatedItem>` tag. Code here can be used to parse that file and extract useful details.


