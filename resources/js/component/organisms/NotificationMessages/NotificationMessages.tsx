import React from 'react';
import { NotificationMessagesProps } from '../../../props/props';
import ButtonFAS from '../../atoms/Buttons/ButtonFAS';
import NotificationMessage from '../../molecules/NotificationMessage/NotificationMessage';
import ErrorBoundary from '../errorboundary';

const NotificationMessages: React.FC<React.PropsWithChildren<NotificationMessagesProps>> = (
  props: NotificationMessagesProps,
): JSX.Element => (
  <ErrorBoundary>
    <div className={`tiles m-b-10 ${props.color}`}>
      <div className="tiles-body">
        {props.headline !== '' && props.headline !== 'undefined' ? (
          <>
            <div className="tiles-title">{props.headline}</div>
            <br />
          </>
        ) : (
          ''
        )}
        {props.messages !== 'undefined'
          ? props.messages.map((item, idx) => (
              <NotificationMessage
                key={idx}
                headline={item.headline}
                description={item.description}
                type={item.type}
                date={item.date}
              />
            ))
          : ''}
      </div>
    </div>
  </ErrorBoundary>
);

export default NotificationMessages;
