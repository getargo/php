Prism.languages.ee = Prism.languages.extend('markup', {
	'eetag': {
		pattern: /(\{|&#123;)\/?exp:\w*:\w*(\s|\n|\t|\w|=|\042|\047|\/|\{|\}|&#123;|&#1235;)*(\}|&#125;)/g,
		inside: {
			'tag_name': {
				pattern: /exp:\w*:\w*/,
				inside: {
					'exp': /exp/,
					'class': /:\w*(?=:)/,
					'method': /\w*(?=[^\w*]*$)/,
					'colon': /:/,
				}
			},
			// insert parameter
			// insert conditional
			// insert bracket
			'keyword': /(if|switch|else)/g
		}
	},
	'embed': {
		pattern: /(&#123;|{)embed=(\047|\042)[\w|\/]*(\047|\042)(&#125;|})/,
		inside: {
			// insert bracket
			'keyword': /embed/g,
			'operator': /=/g,
			'punctuation': /(\047|\042)/g,
			'path': /.*/
		}
	},
	// insert conditional
	'variable': {
		pattern: /(\{|&#123;)\/?\w.*(\}|&#125;)/,
		inside: {
			'bracket':  /\{|&#123;|\}|&#125;/g,
			'parameter': {
				pattern: /\w*=(\042|\047).*(\042|\047)/g,
				inside: {
					'name': /\w+(?=\=)/,
					'operator': /=/,
					'punctuation': /\042|\047/,
					'value': /.+/
				}
			}
		}
	},
	// insert bracket
	'keyword': /(if|switch|else)/g,
	'comment': /(&lt;|\{)!--[\w\W]*?--(&gt;|\})/g
});

Prism.languages.insertBefore('inside', 'keyword', {
	'bracket': Prism.languages.ee.variable.inside.bracket
}, Prism.languages.ee.eetag);

Prism.languages.insertBefore('inside', 'keyword', {
	'bracket': Prism.languages.ee.variable.inside.bracket
}, Prism.languages.ee.embed);

Prism.languages.insertBefore('inside', 'bracket', {
	'conditional': {
		pattern: /(\{|&#123;)\/?if.*(\}|&#125;)/,
		inside: {
			'operator': /(&gt;|&lt;|\076|\075|\074)+/g,
			'bracket':  /\{|&#123;|\}|&#125;/g,
			'keyword': /(if|switch|else)/g,
			'subject': /(\042|\047|\w)+$/,
			'variable': /((\042|\047)\w+(\042|\047))|\w+(?=\}|&#125;|((\076|\075|\074|\s)+))/
		}
	}
}, Prism.languages.ee.eetag);

Prism.languages.insertBefore('inside', 'conditional', {
	'parameter': Prism.languages.ee.variable.inside.parameter
}, Prism.languages.ee.eetag);

Prism.languages.insertBefore('ee', 'variable', {
	'conditional': Prism.languages.ee.eetag.inside.conditional
});

Prism.languages.insertBefore('ee', 'keyword', {
	'bracket': Prism.languages.ee.eetag.inside.bracket
});

// Prism.hooks.add('before-highlight', function(env) {
// 	if(env.language == 'ee') {
// 		var html = env.element.innerHTML;

// 		html = html.replace(/\074/g, '&lt;');
// 		html = html.replace(/\076/g, '&gt;');

// 		env.code = html;
// 	}
// });