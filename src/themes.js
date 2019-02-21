"use strict"

import { future } from "mdx-deck/themes"
import dracula from "prism-react-renderer/themes/dracula"

const futureExtended = {
	...future,
	css: {
		...future.css,
		ul: {
			textAlign: "left"
		}
	},
	codeSurfer: {
		...dracula,
		showNumbers: true
	}
}

export {
	futureExtended
}