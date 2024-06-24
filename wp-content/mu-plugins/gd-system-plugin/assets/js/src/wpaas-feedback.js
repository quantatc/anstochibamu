/** global wpaasFeedback */

import domReady from '@wordpress/dom-ready';
import apiFetch from '@wordpress/api-fetch';
import { render, useState, unmountComponentAtNode, useEffect } from '@wordpress/element';
import { close } from '@wordpress/icons';
import { Icon, RadioControl, Button } from '@wordpress/components';

import { ReactComponent as GoDaddyLogo } from './go-daddy-logo.svg';

const surveyChoices = Array.from({ length: wpaasFeedback?.score_choices.max + 1 }, ( v, k ) => k + wpaasFeedback?.score_choices.min )
							.map( ( choice ) => ( { label: choice, value: choice } ) );

const surveyLabels = wpaasFeedback?.labels;

const startedAt = new Date().toISOString();

const Feedback = () => {
	const [ surveyScore, setSurveyScore ] = useState( null );
	const [ surveyComment, setSurveyComment ] = useState( '' );
	const [ dismissSurvey, setDismissSurvey ] = useState( false );

	const [ showSuccess, setShowSuccess ] = useState( false );

	useEffect( () => {
		if ( dismissSurvey ) {
			unmountComponentAtNode( wpaasFeedback.rootNode.getElementById( wpaasFeedback.mountPoint ) );
		}
	}, [ dismissSurvey ] );

	if ( ! surveyLabels ) {
		return null;
	}

	const handleDismissModal = () => {
		if ( ! showSuccess ) {
			apiFetch( {
				url: wpaasFeedback.apiBase + '/dismiss',
				method: 'POST'
			} );
		}

		setDismissSurvey( true );
	}

	const handleSubmitModal = () => {
		setShowSuccess( true );

		apiFetch( {
			url: wpaasFeedback.apiBase + '/score',
			method: 'POST',
			data: {
				'comment': surveyComment,
				'endedAt': new Date().toISOString(),
				'score': surveyScore,
				startedAt
			}
		} );
	}

	const surveyCommentMaxLength = wpaasFeedback?.comment_length;

	return (
		<div className="wpaas-feedback-modal__container">
			<div className="wpaas-feedback-modal__header">
				<Icon className="wpaas-feedback-modal__header__close" onClick={ handleDismissModal } icon={ close } />
				{ !showSuccess && (
					<GoDaddyLogo />
				)}
			</div>
			<div className="wpaas-feedback-modal__content">
				{ showSuccess ? (
					<>
						<div className="wpaas-feedback__success">
							<GoDaddyLogo />
							<h4 className="wpaas-feedback__success__header">{ surveyLabels?.thank_you }</h4>
							<Button disabled={ !surveyScore ? true : false } onClick={ handleDismissModal } isPrimary>
								{ surveyLabels?.thank_you_button }
							</Button>
						</div>
					</>
				) : (
					<>
						<div className="wpaas-feedback__question-container">
							<label className="wpaas-feedback__question-label">{ surveyLabels?.survey_question }</label>
							<RadioControl
									selected={ surveyScore }
									options={ surveyChoices }
									onChange={ ( value ) => setSurveyScore( Number( value ) ) }
								/>
								<div className="wpaas-feedback__survey-question__labels">
									<p>{ surveyLabels?.not_likely }</p>
									<p>{ surveyLabels?.neutral }</p>
									<p>{ surveyLabels?.likely } </p>
								</div>
						</div>
						<div className="wpaas-feedback__question-container">
							<label className="wpaas-feedback__question-label">{ surveyLabels?.comment_text }</label>
							<div className="wpaas-feedback__textarea__container">
								<textarea
									value={ surveyComment }
									maxLength={ surveyCommentMaxLength }
									onChange={ e => setSurveyComment( e.target.value )}
								/>
								<p className={`wpaas-feedback__textarea__count${ surveyComment.length === surveyCommentMaxLength ? '-bold' : '' }`}>{ surveyComment.length } / { surveyCommentMaxLength }</p>
							</div>
						</div>
						<span>
							<span dangerouslySetInnerHTML={{ __html: surveyLabels?.privacy_disclaimer }} />
						</span>
						<div className="wpaas-feedback__submit-form">
							<Button
								disabled={ surveyScore === null }
								onClick={ handleSubmitModal }
								isPrimary
							>
								{ surveyLabels?.submit_feedback }
							</Button>
						</div>
					</>
				)}
			</div>
		</div>
	);
};

/**
 * customElements need ES5 classes but babel compiles them which errors out. We could use a polyfill or the below.
 * This is needed to circumvent babel crosscompiling.
 */
function BabelHTMLElement() {
	return Reflect.construct( HTMLElement, [], this.__proto__.constructor );
}
Object.setPrototypeOf( BabelHTMLElement, HTMLElement );
Object.setPrototypeOf( BabelHTMLElement.prototype, HTMLElement.prototype );

/**
 * See https://reactjs.org/docs/web-components.html#using-react-in-your-web-components
 */
class GoDaddyFeedback extends BabelHTMLElement {

	connectedCallback() {
		const mountPoint = document.createElement( 'div' );
		mountPoint.id = 'wpaas-feedback';

		function createStyle( url ) {
			const style = document.createElement( 'link' );
			style.setAttribute( 'rel', 'stylesheet' );
			style.setAttribute( 'href', url );
			style.setAttribute( 'media', 'all' );

			return style;
		}

		const shadowRoot = this.attachShadow( { mode: 'open' } );
		shadowRoot.appendChild( createStyle( wpaasFeedback.css ) );
		shadowRoot.appendChild( mountPoint );
		wpaasFeedback.rootNode = shadowRoot;
		wpaasFeedback.mountPoint = mountPoint.id;

		render(
			<Feedback />,
			mountPoint
		);
	}

}

domReady( () => {
	// customElements always need hyphen in the name.
	const customElementName = wpaasFeedback.containerId;

	customElements.define( customElementName, GoDaddyFeedback );

	const element = document.createElement( customElementName );

	// The PHP script actually prints the following tag in the dom <div id="wpaas-feedback-container">.
	// We replace with the custom element the div printed by PHP.
	document.getElementById( customElementName ).replaceWith( element );
} );
