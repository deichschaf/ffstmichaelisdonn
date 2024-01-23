import React, { MouseEventHandler } from 'react';
import classNames from 'classnames';
import { ButtonProps } from '../../../../props/props';
import ErrorBoundary from '../../../organisms/errorboundary';
import Colors from '../../../types/colors';
import convertColorToColorClasses from '../../../utils/convertColorToColorClasses';

const Button: React.FC<React.PropsWithChildren<ButtonProps>> = (props: ButtonProps) => (
  <ErrorBoundary>
    <button
      data-qa={props['data-qa']}
      ref={props.ref}
      className={classNames(
        'button',
        convertColorToColorClasses(props.color),
        props.anchor && 'button--anchor',
        props.className,
      )}
      type={props.type || 'button'}
      onClick={props.onClick}
      name={props.name}
      data-dismiss={props.dataDismiss}
      id={props.id}
      disabled={props.disabled}
    >
      {props.label}
    </button>
  </ErrorBoundary>
);
Button.displayName = 'Button';
export default Button;
