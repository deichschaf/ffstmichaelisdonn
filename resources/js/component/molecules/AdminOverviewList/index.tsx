import React, { useEffect, useState } from 'react';
import { checkContentTitle, deleteLink, editModalLink } from '../../../acp/helper';
import { AdminOverviewListProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';
import LoadingAlertBox from '../LoadingAlertBox';
import SortTable from '../SortTable';

function returnList(props: any, headline) {
  if (props === null) {
    return <></>;
  }
  if (typeof props.contents === 'undefined') {
    return <></>;
  }
  const arr = [...props.contents];
  const ths = ['Content', 'Löschen', 'Editieren'];
  const datas = [] as any;
  arr
    .sort((a, b) => {
      if (a.title.toLowerCase() < b.title.toLowerCase()) return -1;
      if (a.title.toLowerCase() > b.title.toLowerCase()) return 1;
      return 0;
    })
    .map((item, idx) =>
      datas.push([
        { content: checkContentTitle(item.title), className: '' },
        { content: deleteLink(props, item), className: '' },
        { content: editModalLink(props, item), className: '' },
      ] as any),
    );
  return <SortTable headline={headline} table_id="adminOverviewContent" datas={datas} ths={ths} />;
}

const AdminOverviewList: React.FC<React.PropsWithChildren<AdminOverviewListProps>> = (
  props: AdminOverviewListProps,
): JSX.Element => {
  const [loading, setLoading] = useState(false);
  const [appState, setAppState] = useState<any>(null);
  if (typeof props.url === 'undefined') {
    return <></>;
  }
  const fetchURL = props.url;

  // eslint-disable-next-line react-hooks/rules-of-hooks
  useEffect(() => {
    async function fetchMyApi() {
      let response = await fetch(fetchURL);
      response = await response.json();
      setAppState(response);
      setLoading(false);
    }
    fetchMyApi();
  }, [fetchURL]);
  if (loading || appState === null) {
    return <LoadingAlertBox />;
  }
  return <ErrorBoundary>{returnList(appState, props.headline)}</ErrorBoundary>;
};
export default AdminOverviewList;
