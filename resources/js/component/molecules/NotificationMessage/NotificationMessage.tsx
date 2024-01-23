import React from 'react';
import { INotificationMessageProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';

const NotificationMessage: React.FC<React.PropsWithChildren<INotificationMessageProps>> = (
  props: INotificationMessageProps,
): JSX.Element => (
  // info, success, danger
  <ErrorBoundary>
    <div className={`notification-messages ${props.type}`}>
      <div className="message-wrapper">
        <div className="heading">{props.headline}</div>
        <div className="description">{props.description}</div>
      </div>
      <div className="date pull-right">{props.date}</div>
      <div className="clearfix" />
    </div>
  </ErrorBoundary>
);
export default NotificationMessage;
