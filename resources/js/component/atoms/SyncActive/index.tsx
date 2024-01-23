import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import { SyncActiveProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';
import FAS from '../Icon/FAS';

const SyncActive: React.FC<React.PropsWithChildren<SyncActiveProps>> = (
  props: SyncActiveProps,
): JSX.Element => {
  const [getSync, setSync] = useState<boolean>(false);

  function checkSync() {
    fetch('/api/checkOffline')
      .then(response => response.json())
      .then(data => {
        setSync(data.success);
      })
      .catch(error => {
        setSync(false);
        console.error('Error:', error);
      });
  }

  useEffect(() => {
    checkSync();
    const interval = setInterval(() => {
      checkSync();
    }, 120000);
    return () => clearInterval(interval);
  }, []);

  if (!getSync) {
    return (
      <ErrorBoundary>
        <FAS className="lightbulb red" title="Sync inaktiv" />
      </ErrorBoundary>
    );
  }
  return (
    <ErrorBoundary>
      <FAS className="lightbulb green" title="Sync aktiv" />
    </ErrorBoundary>
  );
};
export default SyncActive;
