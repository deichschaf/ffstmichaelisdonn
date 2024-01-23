import React from 'react';
import { AlertBoxOfflineProps } from '../../../../props/props';
import FAS from '../../../atoms/Icon/FAS';
import P from '../../../atoms/Typography/P';

const AlertOfflineBox: React.FC<React.PropsWithChildren<AlertBoxOfflineProps>> = (
  props: AlertBoxOfflineProps,
): JSX.Element => (
  <div className="alert alert-block alert-warning fade in show">
    <h4 className="alert-heading">
      <FAS className="bolt red" /> Offline!
    </h4>
    <P className="" label="Aktuell besteht keine Internetverbindung!!!" />
  </div>
);

export default AlertOfflineBox;
