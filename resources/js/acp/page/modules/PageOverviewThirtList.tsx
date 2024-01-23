import React from 'react';
import ErrorBoundary from '../../../component/organisms/errorboundary';
import { PageOverviewThirtListProps } from '../../../props/props';
import PageOverviewThirt from './PageOverviewThirt';

const PageOverviewThirtList: React.FC<React.PropsWithChildren<PageOverviewThirtListProps>> = (
  props: PageOverviewThirtListProps,
): JSX.Element => (
  <ErrorBoundary>
    {props.upages.map((item, idx) => (
      <PageOverviewThirt
        key={idx}
        page={item.page}
        upages={item.upage}
        deletepath={props.deletepath}
        editpath={props.editpath}
        editheadlinepath={props.editheadlinepath}
        pagecontenttypes={props.pagecontenttypes}
      />
    ))}
  </ErrorBoundary>
);
export default PageOverviewThirtList;
