import { Pipe, PipeTransform } from '@angular/core';
import { DomSanitizer } from '@angular/platform-browser';

@Pipe({name: 'safeScript'})
export class SafeScriptPipe implements PipeTransform {
	constructor(private sanitizer: DomSanitizer) {}
	
	transform(script) {
		return this.sanitizer.bypassSecurityTrustScript(script);
	}
}
