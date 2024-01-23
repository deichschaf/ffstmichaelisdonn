import React from 'react';
import classNames from 'classnames';
import { ButtonFAProps } from '../../../../props/props';
import ErrorBoundary from '../../../organisms/errorboundary';
import convertColorToColorClasses from '../../../utils/convertColorToColorClasses';
import FA from '../../Icon/FA';
import FAS from '../../Icon/FAS';

const ButtonFA: React.FC<React.PropsWithChildren<ButtonFAProps>> = (props: ButtonFAProps) => (
  <ErrorBoundary>
    <button
      className={classNames(
        'button',
        convertColorToColorClasses(props.color),
        props.anchor && 'button--anchor',
        props.className,
      )}
      data-qa={props['data-qa']}
      onClick={props.onClick}
    >
      <FA className={props.FAclassName} title={props.title} />
    </button>
  </ErrorBoundary>
);

export default ButtonFA;
