import React from 'react';

const getComponentDisplayName = <P>(
  WrappedComponent: React.ComponentType<React.PropsWithChildren<P>>
): string => {
  return WrappedComponent.displayName || WrappedComponent.name || 'Component';
};

export default getComponentDisplayName;
