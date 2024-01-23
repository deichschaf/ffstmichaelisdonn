import React from 'react';
import classNames from 'classnames';
import { ButtonFAProps } from '../../../../props/props';
import ErrorBoundary from '../../../organisms/errorboundary';
import convertColorToColorClasses from '../../../utils/convertColorToColorClasses';
import FAR from '../../Icon/FAR';

const ButtonFAR: React.FC<React.PropsWithChildren<ButtonFAProps>> = (props: ButtonFAProps) => (
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
      <FAR className={props.FAclassName} title={props.title} />
    </button>
  </ErrorBoundary>
);

export default ButtonFAR;
